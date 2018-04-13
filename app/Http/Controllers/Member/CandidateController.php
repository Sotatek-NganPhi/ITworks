<?php

namespace App\Http\Controllers\Member;

use App\Consts;
use App\Events\CriteriaChangedEvent;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CandidateRequest;
use App\Http\Requests\UpdateResumeInfoRequest;
use App\Mail\RegisterCandidateSuccess;
use App\Models\Candidate;
use App\Models\CategoryLevel3;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\CompanySize;
use App\Models\Config;
use App\Models\CurrentSituation;
use App\Models\Draft;
use App\Models\DriverLicense;
use App\Models\Education;
use App\Models\EmploymentMode;
use App\Models\Industry;
use App\Models\JumpingCondition;
use App\Models\JumpingDate;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Position;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Models\WorkingPeriod;
use App\Models\WorkingShift;
use App\User;
use DB;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Redirect;

class CandidateController extends AppBaseController
{
    public function updateResumeInfo(UpdateResumeInfoRequest $request)
    {
        if ($this->isSaveCandidateDraft($request)) {
            $this->createOrUpdateCandidateDraft($request);
            return $this->candidateResume($request);
        }
        $inputs = $request->all();
        if (isset($inputs['back']) && $inputs['back'] === 'true') {
            return $this->goToPreviousPageUpdateResumeInfo($request);
        } elseif (!isset($inputs['confirm']) ||
            (isset($inputs['confirm']) && $inputs['confirm'] === 'false')) {
            return $this->goToReviewPageUpdateResumeInfo($request);
        }

        $request->user()->update([
            'first_name'          => $inputs['first_name'],
            'last_name'           => $inputs['last_name'],
            'first_name_phonetic' => $inputs['first_name_phonetic'],
            'last_name_phonetic'  => $inputs['last_name_phonetic'],
            'name'                => $inputs['first_name'] . $inputs['last_name'],
            'name_phonetic'       => $inputs['first_name_phonetic'] . $inputs['last_name_phonetic'],
            'postal_code'         => $inputs['postal_code'],
            'address'             => $inputs['address'],
            'phone_number'        => $inputs['phone_number'],
            'gender'              => $inputs['gender'],
            'birthday'            => $inputs['birthday'],
        ]);

        Candidate::where('user_id', Auth::id())->update([
            'current_situation_id'              => $inputs['current_situation_id'],
            'education_id'                      => $inputs['education_id'],
            'final_academic_school'             => $inputs['final_academic_school'],
            'graduated_at'                      => $inputs['graduated_at'],
            'toeic'                             => $inputs['toeic'],
            'toefl'                             => $inputs['toefl'],
            'language_experience_id'            => $inputs['language_experience_id'],
            'language_conversation_level_id'    => $inputs['language_conversation_level_id'],
            'driver_license_id'                 => $inputs['driver_license_id'],
            'worked_companies_number'           => $inputs['worked_companies_number'],
            'lastest_industry_id'               => $inputs['lastest_industry_id'],
            'lastest_annual_income'             => $inputs['lastest_annual_income'],
            'lastest_job_description'           => $inputs['lastest_job_description'],
            'lastest_company_name'              => $inputs['lastest_company_name'],
            'lastest_position_id'               => $inputs['lastest_position_id'],
            'lastest_employment_mode_id'        => $inputs['lastest_employment_mode_id'],
            'is_married'                        => $inputs['is_married'],
        ]);

        $this->refreshCandidateDraft($request);

        $candidate = Auth::user()->candidate;
        $candidate->certificates()->sync($request->get('certificates', []));

        return $this->goToPageCandidateResume([], false, true);
    }

    public function isSaveCandidateDraft(Request $request)
    {
        if ($request->input('submit') === '下書き保存') {
            return true;
        }
        return false;
    }

    public function candidateResume(Request $request)
    {
        try {
            $user = Auth::user();
            $candidate = Candidate::where('user_id', $user->id)->first();
            $draft = Draft::where('user_id', Auth::id())->first();
            if (!is_null($draft) && !is_null($draft->content)) {
                $draftContent = json_decode($draft->content, true);
                foreach ($user->toArray() as $field => $value) {
                    if(!array_key_exists($field, $draftContent)) {
                        $draftContent[$field] = $value;
                    }
                }
                $request->merge($draftContent);
            } else {
                $this->edit($request);
                $request->merge($user->toArray());
                $request->merge($candidate->toArray());
            }
            $request->flash();

            return $this->goToPageCandidateResume();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getCurrentCandidate()
    {
        $user = Auth::user();
        $candidate = Candidate::where('user_id', $user->id)->first();
        return $this->sendResponse([
            'user'      => $user,
            'candidate' => $candidate
        ], 'Data retrieved successfully');
    }

    public function create(Request $request, $formAction = 'candidate.store')
    {
        if ($formAction === 'candidate.store') {
            $draft = Draft::where('user_id', Auth::id())->first();
            if (!is_null($draft) && !is_null($draft->content)) {
                $request->merge(json_decode($draft->content, true));
                $request->flash();
            }
        }
        $user = Auth::user();
        $configs = Config::getConfigByKey();

        $request->merge(['formAction' => $formAction]);
        $request->flash();

        return view('auth.candidate', [
            'user'                       => $user,
            'currentSituations'          => CurrentSituation::getAll(),
            'jumpingConditions'          => JumpingCondition::getAll(),
            'jumpingDates'               => JumpingDate::getAll(),
            'educations'                 => Education::getAll(),
            'employmentModes'            => EmploymentMode::getAll(),
            'industries'                 => Industry::getAll(),
            'companySizes'               => CompanySize::getAll(),
            'positions'                  => Position::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'driverLicenses'             => DriverLicense::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingShifts'              => WorkingShift::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'workingPeriods'             => WorkingPeriod::getAll(),
            'categoryLevel3s'            => CategoryLevel3::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
            'configs'                    => $configs,
        ]);
    }

    public function syncAllRelations(Request $request, $candidate)
    {
        $changes = [];
        $changes[] = $candidate->prefectures()->sync($request->get('prefectures', []));
        $changes[] = $candidate->industries()->sync($request->get('industries', []));
        $changes[] = $candidate->companySizes()->sync($request->get('company_sizes', []));
        $changes[] = $candidate->employmentModes()->sync($request->get('employment_modes', []));
        $changes[] = $candidate->categoryLevel3s()->sync($request->get('category_level_3s', []));
        $changes[] = $candidate->currentSituations()->sync($request->get('current_situations', []));
        $changes[] = $candidate->merits()->sync($request->get('merits', []));
        $changes[] = $candidate->salaries()->sync($request->get('salaries', []));
        $changes[] = $candidate->workingShifts()->sync($request->get('working_shifts', []));
        $changes[] = $candidate->workingDays()->sync($request->get('working_days', []));
        $changes[] = $candidate->workingHours()->sync($request->get('working_hours', []));
        $changes[] = $candidate->workingPeriods()->sync($request->get('working_periods', []));
        $changes[] = $candidate->certificates()->sync($request->get('certificates', []));

        $changedRecords = collect($changes)->reduce(function ($carry, $change) {
            return $carry + count($change['attached']) + count($change['detached']) + count($change['updated']);
        });

        if ($changedRecords > 0) {
            event(new CriteriaChangedEvent($candidate));
        }
    }

    public function store(CandidateRequest $request)
    {
        $user = Auth::user();
        $platform = (new Agent())->isDesktop() ? Consts::PLATFORM_PC : Consts::PLATFORM_MOBILE;
        $input = $request->all();
        if ($this->isSaveCandidateDraft($request)) {
            $this->createOrUpdateCandidateDraft($request);
            return redirect()->route('candidate.edit');
        }
        if (!is_null($input['graduated_at'])) {
            $input['graduated_at'] = \Carbon\Carbon::parse($input['graduated_at']);
        }

        DB::beginTransaction();
        try {
            $candidate = new Candidate($input);
            $candidate->user_id = $user->id;
            $candidate->platform_flag = pow(2, $platform);
            $candidate->save();
            $user->mail_receivable = $input['mail_receivable'];
            $user->save();

            $this->refreshCandidateDraft($request);

            $this->syncAllRelations($request, $candidate);
            Mail::to($user)->queue(new RegisterCandidateSuccess($user));
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
        return redirect('/');
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $candidate = $user->candidate;

        $draft = Draft::where('user_id', Auth::id())->first();
        if (!is_null($draft) && !is_null($draft->content)) {
            $request->merge(json_decode($draft->content, true));
        } else {
            $relations = [
                'prefectures'        => $candidate->prefectures->pluck('id')->toArray(),
                'industries'         => $candidate->industries->pluck('id')->toArray(),
                'company_sizes'      => $candidate->companySizes->pluck('id')->toArray(),
                'employment_modes'   => $candidate->employmentModes->pluck('id')->toArray(),
                'category_level_3s'  => $candidate->categoryLevel3s->pluck('id')->toArray(),
                'current_situations' => $candidate->currentSituations->pluck('id')->toArray(),
                'merits'             => $candidate->merits->pluck('id')->toArray(),
                'salaries'           => $candidate->salaries->pluck('id')->toArray(),
                'working_shifts'     => $candidate->workingShifts->pluck('id')->toArray(),
                'working_days'       => $candidate->workingDays->pluck('id')->toArray(),
                'working_hours'      => $candidate->workingHours->pluck('id')->toArray(),
                'working_periods'    => $candidate->workingPeriods->pluck('id')->toArray(),
                'certificates'       => $candidate->certificates->pluck('id')->toArray(),
            ];

            $request->merge($candidate->toArray());
            $request->merge($relations);
            $request->merge(['mail_receivable' => $user->mail_receivable]);
        }

        $request->flash();

        return $this->create($request, 'candidate.update');
    }

    public function update(CandidateRequest $request)
    {
        if ($this->isSaveCandidateDraft($request)) {
            $this->createOrUpdateCandidateDraft($request);
            return redirect()->route('candidate.edit');
        }
        $user = Auth::user();
        $candidate = $user->candidate;

        DB::beginTransaction();
        try {
            $candidate->update($request->all());
            $candidate->save();
            $user->mail_receivable = $request->input('mail_receivable');
            $user->save();
            $this->syncAllRelations($request, $candidate);

            $this->refreshCandidateDraft($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
        return redirect(route('member_home'));
    }

    public function leave()
    {
        $candidate = Auth::user()->candidate;

        DB::beginTransaction();

        try {

            $candidate->user()->delete();
            $candidate->categoryLevel1s()->delete();
            $candidate->categoryLevel2s()->delete();
            $candidate->categoryLevel3s()->delete();
            $candidate->employmentModes()->delete();
            $candidate->companySizes()->delete();
            $candidate->merits()->delete();
            $candidate->prefectures()->delete();
            $candidate->workingDays()->delete();
            $candidate->workingHours()->delete();
            $candidate->workingPeriods()->delete();
            $candidate->workingShifts()->delete();
            $candidate->industries()->delete();
            $candidate->currentSituations()->delete();
            $candidate->salaries()->delete();
            $candidate->certificate()->delete();
            $candidate->delete();
            DB::commit();

            Auth::logout();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }

        return redirect(route('index'));
    }

    private function goToPreviousPageUpdateResumeInfo(Request $request)
    {
        $inputs = $request->all();

        $request->merge($inputs);
        $request->flash();

        return $this->goToPageCandidateResume($inputs);
    }

    private function goToReviewPageUpdateResumeInfo(Request $request)
    {
        $inputs = $request->all();
        return $this->goToPageCandidateResume($inputs, true);
    }

    private function goToPageCandidateResume($inputs = [],
                                             $submitted = false, $success = false, $errors = [])
    {
        return response()->view('app.member.candidate_resume', [
            'errors'                     => $errors,
            'inputs'                     => $inputs,
            'submitted'                  => $submitted,
            'success'                    => $success,
            'prefectures'                => Prefecture::getAll(),
            'currentSituations'          => CurrentSituation::getAll(),
            'jumpingConditions'          => JumpingCondition::getAll(),
            'jumpingDates'               => JumpingDate::getAll(),
            'educations'                 => Education::getAll(),
            'employmentModes'            => EmploymentMode::getAll(),
            'industries'                 => Industry::getAll(),
            'companySizes'               => CompanySize::getAll(),
            'positions'                  => Position::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'driverLicenses'             => DriverLicense::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingShifts'              => WorkingShift::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'workingPeriods'             => WorkingPeriod::getAll(),
            'categoryLevel3s'            => CategoryLevel3::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
    }

    public function createOrUpdateCandidateDraft(Request $request)
    {
        $draft = $request->user()->draft;
        if (is_null($draft)) {
            $request->user()->draft()->create([
                'content' => json_encode($request->all())
            ]);
        } else {
            $candidateRelationTable = [
                'prefectures',
                'industries',
                'company_sizes',
                'employment_modes',
                'category_level_3s',
                'current_situations',
                'merits',
                'salaries',
                'working_shifts',
                'working_days',
                'working_hours',
                'working_periods',
                'certificates',
            ];
            $draft = Draft::where('user_id', Auth::id())->first();
            if(is_null($draft)) {
                return;
            }
            $draftContent = json_decode($draft->content, true);
            $inputs = $request->all();
            if(!is_null($draftContent)) {
                foreach ($draftContent as $field => $value) {
                    if (!in_array($field, $candidateRelationTable)) {
                        if (!array_key_exists($field, $inputs)) {
                            $inputs[$field] = $value;
                        }
                    }
                }
            }

            $request->user()->draft()->update([
                'content' => json_encode($inputs)
            ]);
        }
    }

    public function refreshCandidateDraft(Request $request)
    {
        $request->user()->draft()->update([
            'content' => null
        ]);
    }
}

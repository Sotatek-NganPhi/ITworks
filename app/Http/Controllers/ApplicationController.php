<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\ApplyJobRequest;
use App\Mail\ApplicationToEmployer;
use App\Models\CategoryLevel3;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\CompanySize;
use App\Models\CurrentSituation;
use App\Models\DriverLicense;
use App\Models\Education;
use App\Models\EmploymentMode;
use App\Models\Industry;
use App\Models\Job;
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
use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;

class ApplicationController extends AppBaseController
{
    public function showAppliedJobs(Request $request)
    {
        $user = $request->user();
        $jobs = Applicant::where('user_id', $user->id)
            ->join('jobs', 'jobs.id', 'applicants.job_id')
            ->paginate(10);
        return view('app.member.applied_job_list', ['jobs' => $jobs]);
    }

    public function store(ApplyJobRequest $request)
    {
        DB::beginTransaction();

        try {

            $inputs = $request->all();
            if (isset($inputs['back']) && $inputs['back'] === 'true') {
                return $this->goToPreviousPageApplyJob($request);
            } elseif (!isset($inputs['confirm']) ||
                (isset($inputs['confirm']) && $inputs['confirm'] === 'false')) {
                return $this->goToReviewPageApplyJob($request);
            }

            $job = Job::findOrFail($inputs['job_id']);

            $applicant = Applicant::firstOrNew([
                'user_id'                        => Auth::id(),
                'job_id'                         => $inputs['job_id'],
                'email'                          => $inputs['email'],
            ]);

            $applicant->first_name = $inputs['first_name'];
            $applicant->last_name = $inputs['last_name'];
            $applicant->first_name_phonetic = $inputs['first_name_phonetic'];
            $applicant->last_name_phonetic = $inputs['last_name_phonetic'];
            $applicant->address = $inputs['address'];
            $applicant->phone_number = $inputs['phone_number'];
            $applicant->gender = $inputs['gender'];
            $applicant->postal_code = $inputs['postal_code'];
            $applicant->birthday = $inputs['birthday'];
            $applicant->current_situation_id = $inputs['current_situation_id'];
            $applicant->education_id = $inputs['education_id'];
            $applicant->final_academic_school = $inputs['final_academic_school'];
            $applicant->graduated_at = $inputs['graduated_at'];
            $applicant->toeic = $inputs['toeic'];
            $applicant->toefl = $inputs['toefl'];
            $applicant->language_experience_id = $inputs['language_experience_id'];
            $applicant->language_conversation_level_id = $inputs['language_conversation_level_id'];
            $applicant->driver_license_id = $inputs['driver_license_id'];
            $applicant->worked_companies_number = $inputs['worked_companies_number'];
            $applicant->lastest_company_name = $inputs['lastest_company_name'];
            $applicant->lastest_position_id = $inputs['lastest_position_id'];
            $applicant->lastest_industry_id = $inputs['lastest_industry_id'];
            $applicant->lastest_annual_income = $inputs['lastest_annual_income'];
            $applicant->lastest_job_description = $inputs['lastest_job_description'];
            $applicant->resume_pr = $inputs['resume_pr'];
            $applicant->status = $inputs['status'];
            $applicant->lastest_employment_mode_id = $inputs['lastest_employment_mode_id'];
            $applicant->is_married = $inputs['is_married'];
            $applicant->save();

            $applicant->certificates()->sync($request->get('certificates', []));

            // TODO: do we need to send mail to candidate?

            Mail::to(['email' => $job['email_receive_applicant']])
                ->queue(new ApplicationToEmployer($job, $applicant));

            DB::commit();
            return $this->goToPageApplyJob($inputs, false, true);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(null, $e->getMessage());
        }
    }

    private function goToPreviousPageApplyJob(Request $request)
    {
        $inputs = $request->all();

        $request->merge($inputs);
        $request->flash();

        return $this->goToPageApplyJob($inputs);
    }

    private function goToReviewPageApplyJob(Request $request)
    {
        $inputs = $request->all();
        return $this->goToPageApplyJob($inputs, true);
    }

    private function goToPageApplyJob($inputs = [],
                                      $submitted = false, $success = false, $errors = [])
    {
        return response()->view('app.job_application', [
            'job'                        => Job::find($inputs['job_id']),
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
}
<?php

namespace App\Http\Controllers\Member;

use App\Consts;
use App\Events\CriteriaChangedEvent;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CandidateRequest;
use App\Http\Requests\UpdateResumeInfoRequest;
use App\Http\Services\JobService;
use App\Http\Services\UrgentJobService;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Mail\RegisterCandidateSuccess;
use App\Models\Candidate;
use App\Models\Config;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Draft;
use Carbon\Carbon;
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
    protected $jobService;
    protected $urgentJobService;

    public function __construct(
        JobService $jobService, UrgentJobService $urgentJobService
        )
    {
        $this->jobService = $jobService;
        $this->urgentJobService = $urgentJobService;
    }

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
            'name'                => $inputs['first_name'] . $inputs['last_name'],
            'address'             => $inputs['address'],
            'phone_number'        => $inputs['phone_number'],
            'gender'              => $inputs['gender'],
            'birthday'            => $inputs['birthday'],
        ]);

        Candidate::where('user_id', Auth::id())->update([
            'education'                      => $inputs['education'],
            'final_academic_school'             => $inputs['final_academic_school'],
            'graduated_at'                      => $inputs['graduated_at'],
            'language'            => $inputs['language'],
            'language_level'    => $inputs['language_level'],
        ]);

        $this->refreshCandidateDraft($request);

        $candidate = Auth::user()->candidate;
        $candidate->certificates()->sync($request->get('certificates', []));

        return $this->goToPageCandidateResume([], false, true);
    }

    public function isSaveCandidateDraft(Request $request)
    {
        if ($request->input('submit') === 'Lưu bản nháp') {
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
        $prefectureIds = Region::getPrefectureIds(1);
        return view('auth.candidate', [
            'user'                       => $user,
            'regions'                    => Region::with('prefectures')->get(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
            'configs'                    => $configs,
        ]);
    }

    public function syncAllRelations(Request $request, $candidate)
    {
        $changes = [];
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
            $candidate->save();
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
                'prefectures'        => $candidate->prefectures,
                'certificates'       => $candidate->certificates,
            ];

            $request->merge($candidate->toArray());
            $request->merge($relations);
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
            $candidate->prefectures()->delete();
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
            'regions'                    => Region::with('prefectures')->get(),
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

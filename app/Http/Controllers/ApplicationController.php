<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\ApplyJobRequest;
use App\Mail\ApplicationToEmployer;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Education;
use App\Models\Job;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
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
            $applicant->address = $inputs['address'];
            $applicant->phone_number = $inputs['phone_number'];
            $applicant->gender = $inputs['gender'];
            $applicant->birthday = $inputs['birthday'];
            $applicant->education_id = $inputs['education_id'];
            $applicant->final_academic_school = $inputs['final_academic_school'];
            $applicant->graduated_at = $inputs['graduated_at'];
            $applicant->toeic = $inputs['toeic'];
            $applicant->toefl = $inputs['toefl'];
            $applicant->language_experience_id = $inputs['language_experience_id'];
            $applicant->language_conversation_level_id = $inputs['language_conversation_level_id'];
            $applicant->status = $inputs['status'];
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
            'educations'                 => Education::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
    }
}
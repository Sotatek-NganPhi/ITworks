<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Services\JobService;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Config;
use App\Models\Job;
use App\Models\Region;
use App\Models\UserBookmark;
use App\Models\JobCounter;
use App\Models\Prefecture;
use App\Utils;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use League\Csv\Writer;
use SplTempFileObject;

class JobController extends AppBaseController
{
    protected $jobService;
    protected $jobCounter;

    public function __construct()
    {
        $this->jobService = new JobService();
    }

    public function search(Request $request, $keyRegion)
    {
        try {
            $results = $this->jobService->search($request, $keyRegion);
            $conditions = $this->jobService->getInfoConditionsSearch($request);
            return view('app.search',
                [
                    'regions' => Region::getAll(),
                    "results" => $results,
                    "region" => Region::getRegionByKey($keyRegion),
                    "conditions" => $conditions,
                    "params" => $request->all()
                ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function apply($id, Request $request)
    {
        try {
            $job = $this->jobService->show($id);
            $user = Auth::user();
            $candidate = Candidate::where('user_id', Auth::id())->first();

            $applicant = Applicant::firstOrNew(['user_id' => Auth::id() , 'job_id' => $id]);
            if($applicant->exists) {
                $request->merge($applicant->toArray());
                $relations = [
                    'certificates'       => $applicant->certificates->pluck('id')->toArray(),
                ];
            } else {
                $request->merge($candidate->toArray());
                $request->merge($user->toArray());
                $relations = [
                    'certificates'       => $candidate->certificates->pluck('id')->toArray(),
                ];
            }

            $request->merge($relations);
            $request->flash();

            return response()->view('app.job_application', [
                'job'                        => $job,
                'prefectures'                => Prefecture::getAll(),
                'regions'                    => Region::with('prefectures')->get(),
                'certificate_groups'         => CertificateGroup::getAll(),
                'certificates'               => Certificate::getAll(),
            ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $job = $this->jobService->show($id);
            if (is_null($job)) {
                abort(404);
            }

            $isBookmark = false;
            if(Auth::check()){
                $userBookmark = UserBookmark::where('job_id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->get();
                $isBookmark = !$userBookmark->isEmpty();
            }

            $this->updateJobCounter($id);
            $optionalFields = [
                'company_name',
                'application_condition',
            ];

            return view('app.job_detail',
                        [
                            "job" => $job,
                            "isBookmark" => $isBookmark,
                            'optionalFields' => $optionalFields
                        ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function showJobSendMobile($jobId)
    {
        try {
            $job = $this->jobService->show($jobId);
            if (is_null($job)) {
                abort(404);
            }
            $this->updateJobCounter($jobId);
            return view('app.job_send_mobile',
                [
                    "job" => $job,
                ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function sendJobToMailMobile(Request $request, Job $job){
        Mail::to($request->mail)->queue(new \App\Mail\SendJob($job));
        return view('app.job_send_mobile', ["job" => $job, 'isSuccess' => true]);
    }

    public function showJobClips(Request $request, Job $job){
        if(!Auth::check()){
            $request->session()->put('url._intended', $request->fullUrl());
            $request->session()->put('url._view', "app.job_clip");
        }else{
            if ($request->session()->has('url._intended')) {
                $view = $request->session()->get('url._view');
                if(Auth::check()) {
                    $request->session()->forget('url._intended');
                    $request->session()->forget('url._view');
                }
                return view($view, ['job' => $job]);
            }
        }
        return view('app.job_clip', ["job" => $job]);
    }

    public function addJobClips(Job $job){
        UserBookmark::firstOrCreate([
            'job_id' => $job->id,
            'user_id' => Auth::user()->id,
        ]);
        return view('app.job_clip_success', ["job" => $job]);
    }
    
    public function updateJobCounter($jobId)
    {
        $today = Carbon::now(Consts::TIME_ZONE_VIETNAM)->toDateString();
        $jobCounter = JobCounter::firstOrCreate([
            'job_id' => $jobId,
            'view_date' => $today
        ]);
        $jobCounter->increment('views');
        $jobCounter->save();
    }

    public function showRegisterConditionPage(Request $request)
    {
        if ($request->session()->has('url._intended')) {
            $params = $request->session()->get('url._params', []);
            $view = $request->session()->get('url._view');
            if(Auth::check()) {
                $request->session()->forget('url._intended');
                $request->session()->forget('url._view');
                $request->session()->forget('url._params');
            }
            return view($view, ['params' => $params]);
        }
        return view('app.register_condition');
    }

    public function registerCondition(Request $request, $params = [])
    {
        $params = empty($params) ? $request->all() : [];
        if(!Auth::check()){
            $request->session()->put('url._intended', $request->fullUrl());
            $request->session()->put('url._view', "app.register_condition");
            $request->session()->put('url._params', $params);
        }
        return view('app.register_condition', ["params" => $params]);
    }

    public function getJobReference(Request $request)
    {
        $data = [];
        $data['similar_category'] = [];
        $data['similar_category_history'] = [];
        $data['history'] = [];
        $jobId = $request->input('job_id');
        if(empty($request->input('history'))) {
            return $this->sendResponse($data, "Get data success");
        }
        $history = explode(",", $request->input('history'));
        $data['similar_category'] = $this->getSimilarCategoryJob($jobId);
        $data['similar_category_history'] = $this->getSimilarCategoryJobInHistory($history, $jobId);
        $data['history'] = $this->getJobOtherInHistory($history, $jobId);

        return $this->sendResponse($data, "Get data success");

    }

    private function getSimilarCategoryJob($jobId)
    {
        try {
            $jobs = Job::whereIn('jobs.id', $jobIds)
                ->with(['prefectures', 'salaries'])->get();
            return $jobs;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getJobOtherInHistory($history, $jobId)
    {
        return Job::whereIn('jobs.id', $history)
            ->where('jobs.id', '!=', $jobId)
            ->with(['prefectures', 'salaries'])->get();
    }

    private function getIdsOfJob($jobId)
    {
        $job = Job::find($jobId);
        if (is_null($job)) {
            return [];
        }
        return $job;
    }
}

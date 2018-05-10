<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Services\JobService;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Education;
use App\Models\Config;
use App\Models\Job;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Position;
use App\Models\Region;
use App\Models\UserBookmark;
use App\Models\JobCounter;
use App\Models\Prefecture;
use App\Models\Salary;
use App\Models\Ward;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Models\WorkingPeriod;
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
                'educations'                 => Education::getAll(),
                'positions'                  => Position::getAll(),
                'regions'                    => Region::with('prefectures')->get(),
                'languageExperiences'        => LanguageExperience::getAll(),
                'languageConversationLevels' => LanguageConversationLevel::getAll(),
                'salaries'                   => Salary::getAll(),
                'workingDays'                => WorkingDay::getAll(),
                'workingHours'               => WorkingHour::getAll(),
                'workingPeriods'             => WorkingPeriod::getAll(),
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
                'option_3',
                'option_4',
                'option_5',
                'salary',
                'option_7',
                'option_8',
                'option_9',
                'option_10',
                'option_11',
                'option_12',
                'option_13',
                'option_14',
                'option_15',
                'option_16',
                'option_17',
                'option_18',
                'option_19',
                'option_20'
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

    public function downloadSampleCsv()
    {
        $fieldsEn = [];
        $fieldsJp = [];
        $rules = $this->jobService->loadRule();
        foreach ($rules as $header => $rule) {
            $fieldsEn[] = Utils::utf8ToSjis($header);
            $fieldsJp[] = Utils::utf8ToSjis($rule->fields_jp);
        }

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne($fieldsEn);
        $csv->insertOne($fieldsJp);

        $csv->output("sample_job_insert.csv");
    }

    public function downloadCsvCategoryLevel2s()
    {
        $headers = [
            'category_level3_id' => Utils::utf8ToSjis('小職種コード'),
            'category_level3_name' => Utils::utf8ToSjis('小職種名'),
        ];
        $rows = CategoryLevel3::select("category_level3s.id as category_level3_id",
                "category_level3s.name as category_level3_name")
            ->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));

        return Utils::downloadCSV($headers, $data, "job_category");
    }

    public function downloadCsvPrefectures()
    {
        $headers = [
            'prefecture_id' => Utils::utf8ToSjis('都道府県コード'),
            'prefecture_name' => Utils::utf8ToSjis('都道府県'),
        ];
        $rows = Prefecture::select("id as prefecture_id", "name as prefecture_name")->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));

        return Utils::downloadCSV($headers, $data, "prefectures");
    }

    public function downloadCsvWorkingDays()
    {
        $headers = [
            'working_day_id' => Utils::utf8ToSjis('希望の勤務日数コード'),
            'working_day_name' => Utils::utf8ToSjis('希望の勤務日数'),
        ];
        $rows = WorkingDay::select("working_days.id as working_day_id",
            "working_days.name as working_day_name")->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));

        return Utils::downloadCSV($headers, $data, "working_days");
    }

    public function downloadCsvWorkingHours()
    {
        $headers = [
            'working_hour_id' => Utils::utf8ToSjis('希望の勤務時間コード'),
            'working_hour_name' => Utils::utf8ToSjis('希望の勤務時間'),
        ];
        $rows = WorkingHour::select("working_hours.id as working_hour_id",
            "working_hours.name as working_hour_name")->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));

        return Utils::downloadCSV($headers, $data, "working_hours");
    }

    public function downloadCsvWorkingPeriods()
    {
        $headers = [
            'working_period_id' => Utils::utf8ToSjis('希望の勤務期間コード'),
            'working_period_name' => Utils::utf8ToSjis('希望の勤務期間'),
        ];
        $rows = WorkingPeriod::select("working_periods.id as working_period_id",
            "working_periods.name as working_period_name")->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));

        return Utils::downloadCSV($headers, $data, "working_periods");
    }

    public function downloadCsvSalaries()
    {
        $headers = [
            'salary_id' => Utils::utf8ToSjis('給与コード'),
            'salary_category' => Utils::utf8ToSjis('給与カテゴリ'),
            'salary_description' => Utils::utf8ToSjis('給与'),
        ];
        $rows = Salary::select("id as salary_id",
            'category as salary_category',
            "salaries.description as salary_description")->get();
        $data = Utils::buildContentFileExcel($rows, array_keys($headers));
        return Utils::downloadCSV($headers, $data, "salaries");
    }

    public function updateJobCounter($jobId)
    {
        $today = Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString();
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
            $categoryLevel3Ids = $this->getCategoryLevel3IdsOfJob($jobId);
            $jobIds = CategoryLevel3::join('job_category_level3',
                'job_category_level3.category_level3_id', 'category_level3s.id')
                ->join('job_counters', 'job_counters.job_id', 'job_category_level3.job_id')
                ->where('job_category_level3.job_id', '!=', $jobId)
                ->whereIn('category_level3s.id', $categoryLevel3Ids)
                ->orderBy('job_counters.views', 'desc')
                ->limit(Consts::DEFAULT_SQL_LIMIT)
                ->pluck('job_category_level3.job_id');
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

    private function getCategoryLevel3IdsOfJob($jobId)
    {
        $job = Job::find($jobId);
        if (is_null($job)) {
            return [];
        }
        $categoryLevel3s = $job->categoryLevel3s;
        $categoryLevel3Ids = $categoryLevel3s->pluck('id');

        if(empty($categoryLevel3Ids)) {
            return [];
        }

        return $categoryLevel3Ids;
    }
}

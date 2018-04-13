<?php

namespace App\Http\Controllers\API;

use App\Utils;
use Response;
use App\Consts;
use App\Models\Job;
use App\Models\Region;
use App\Http\Services\AnalysisService;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AnalysisAPIController extends AppBaseController
{
    protected $analysisService;

    public function __construct()
    {
        $this->analysisService = new AnalysisService();
    }

        public function downloadCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(Utils::utf8ToSjis('仕事詳細情報閲覧数,応募数'));
        $csv->insertOne(Utils::utf8ToSjis('PC,スマートフォン,PC,スマートフォン'));
        $monthAnalysis=$this->getMonthSearchAnalysis($request)->getData()->data;
        $csv->insertOne(Utils::utf8ToSjis(get_object_vars($monthAnalysis)));
        $csv->insertOne(Utils::utf8ToSjis('日付,PC仕事詳細情報閲覧数,スマートフォン仕事詳細情報閲覧数,PC応募数,スマートフォン応募数'));
        $csv->insertOne('');
        $json_string = $this->getDaySearchAnalysis($request)->getData()->data;
        foreach ($json_string as $key => $value)
        {
             $csv->insertOne( Utils::utf8ToSjis(get_object_vars($value)));
        }
         $csv->output('analysis.csv');
    }

    public function criteriaAnalysis(Request $request)
    {
        $region = null;
        $analysisParams = $request->all();
        $analysisSearch = $analysisParams["analysisSearch"];
        $criteria = $analysisSearch["criteria"];

        if (!$criteria) {
            return $this->sendError('Criteria is the required parameter');
        }

        if (isset($analysisSearch["region"])) {
            $region = Region::find($analysisSearch["region"]);
            if (is_null($region)) {
                return $this->sendError(trans('message.unfound'));
            }
        }

        $nameTableCriteria = Str::plural(Str::snake($criteria));
        if (!Schema::hasTable($nameTableCriteria)) {
            return $this->sendError('Table ' . $nameTableCriteria . ' not exist');
        }
        $joiningTableJob = $this->getNameJoiningTableJob($criteria);
        if (!Schema::hasTable($joiningTableJob)) {
            return $this->sendError('Table ' . $joiningTableJob . ' not exist');
        }

        $resultAnalysis["results"] = $this->analysisService->criteriaAnalysis(
            $nameTableCriteria,
            $joiningTableJob,
            $analysisSearch,
            $region,
            $criteria
        );
        $resultAnalysis["region"] = $region;

        return $this->sendResponse($resultAnalysis, trans('message.retrieve'));
    }


    protected function getNameJoiningTableJob($name)
    {
        return "job_" . $name;
    }

    public function analyzeOverTime(Request $request)
    {
        $analysisParams = $request->all();
        if (!$analysisParams["criteria_time"]) {
            return $this->sendError('Time is the required parameter');
        }
        $resultAnalysis = $this->analysisService->analyzeOverTime($analysisParams["criteria_time"]);
        return $this->sendResponse($resultAnalysis, trans('message.retrieve'));
    }

    public function getMonthlyAnalysis($year, $month)
    {
        $monthData = array();

        $monthData['new_job'] = DB::table('jobs')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->count();

        $viewQuery = DB::table('job_counters')
                    ->whereYear('view_date', '=', $year)
                    ->whereMonth('view_date', '=', $month);
        $monthData['views'] = $viewQuery->sum('views');

        $monthData['applicant'] = DB::table('applicants')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->count();


        $monthData['registrant'] = DB::table('candidates')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->count();

        return $this->sendResponse($monthData, trans('message.analysis'));
    }

    public function getDaylyAnalysis($year, $month)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $result = array();
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayData = array();
            $dayData['date'] = $day;
            $dayData['available_job'] = DB::table('jobs')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->whereDay('created_at', '=', $day)
                        ->count();

            $viewQuery = DB::table('job_counters')
                        ->whereYear('view_date', '=', $year)
                        ->whereMonth('view_date', '=', $month)
                        ->whereDay('view_date', '=', $day);
            $dayData['views'] = $viewQuery->sum('views');

            $dayData['applicant'] = DB::table('applicants')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->whereDay('created_at', '=', $day)
                    ->count();

            $dayData['registrant'] = DB::table('candidates')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->whereDay('created_at', '=', $day)
                    ->count();
            array_push($result, $dayData);
        }
        return $this->sendResponse($result, trans('message.analysis'));
    }

    public function getMonthSearchAnalysis(Request $request)
    {
        $params = $request->all();
        $monthData = array();
        $viewQuery = DB::table('job_counters')
                ->join('jobs', 'job_counters.job_id', '=', 'jobs.id')
                ->whereYear('job_counters.view_date', '=', $params['selectedYear'])
                ->whereMonth('job_counters.view_date', '=', $params['selectedMonth']);

        $applicantQuery = DB::table('applicants')
                ->join('jobs', 'applicants.job_id', '=', 'jobs.id')
                ->whereYear('applicants.created_at', '=', $params['selectedYear'])
                ->whereMonth('applicants.created_at', '=', $params['selectedMonth']);

        $query = $this->appendAnalysisSearchQuery($params, $viewQuery, $applicantQuery);
        $viewQuery = $query['view_query'];
        $applicantQuery = $query['applicant_query'];

        $monthData['views'] = $viewQuery->sum('views');

        $monthData['applicant'] = $applicantQuery->count();
        return $this->sendResponse($monthData, trans('message.analysis'));
    }

    public function getDaySearchAnalysis(Request $request)
    {
        $params = $request->all();
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $params['selectedMonth'], $params['selectedYear']);
        $result = array();
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $viewQuery = DB::table('job_counters')
                    ->join('jobs', 'job_counters.job_id', '=', 'jobs.id')
                    ->whereYear('job_counters.view_date', '=', $params['selectedYear'])
                    ->whereMonth('job_counters.view_date', '=', $params['selectedMonth']);

            $applicantQuery = DB::table('applicants')
                    ->join('jobs', 'applicants.job_id', '=', 'jobs.id')
                    ->whereYear('applicants.created_at', '=', $params['selectedYear'])
                    ->whereMonth('applicants.created_at', '=', $params['selectedMonth'])
                    ->whereDay('applicants.created_at', '=', $day);

            $query = $this->appendAnalysisSearchQuery($params, $viewQuery, $applicantQuery);
            $viewQuery = $query['view_query'];
            $applicantQuery = $query['applicant_query'];

            $dayData = array();
            $dayData['date'] = $day;
            $dayData['views'] = $viewQuery->whereDay('view_date', '=', $day)->sum('views');
            $dayData['applicant'] = $applicantQuery->count();
            array_push($result, $dayData);
        }
        return $this->sendResponse($result, trans('message.analysis'));
    }

    function appendAnalysisSearchQuery($params, $viewQuery, $applicantQuery)
    {
        if (isset($params['prefecture_id'])) {
            $viewQuery = $viewQuery->join('job_prefecture', 'job_counters.job_id', '=', 'job_prefecture.job_id');
            $viewQuery = $viewQuery->where('job_prefecture.prefecture_id', '=', $params['prefecture_id']);

            $applicantQuery = $applicantQuery->join('job_prefecture', 'applicants.job_id', '=', 'job_prefecture.job_id');
            $applicantQuery = $applicantQuery->where('job_prefecture.prefecture_id', '=', $params['prefecture_id']);
        }

        if (isset($params['category_lv3_id'])) {
            $viewQuery = $viewQuery->join('job_category_level3', 'job_counters.job_id', '=', 'job_category_level3.job_id');
            $viewQuery = $viewQuery->where('job_category_level3.category_level3_id', '=', $params['category_lv3_id']);

            $applicantQuery = $applicantQuery->join('job_category_level3', 'applicants.job_id', '=', 'job_category_level3.job_id');
            $applicantQuery = $applicantQuery->where('job_category_level3.category_level3_id', '=', $params['category_lv3_id']);
        }

        if (isset($params['company_id'])) {
            $viewQuery = $viewQuery->where('jobs.company_id', '=', $params['company_id']);
            $applicantQuery = $applicantQuery->where('jobs.company_id', '=', $params['company_id']);
        }

        if (isset($params['job_id'])) {
            $viewQuery = $viewQuery->where('job_counters.job_id', '=', $params['job_id']);
            $applicantQuery = $applicantQuery->where('applicants.job_id', '=', $params['job_id']);
        }
        return ['view_query' => $viewQuery,
                'applicant_query' => $applicantQuery];
    }

}

<?php

namespace App\Http\Services;

use App\Consts;
use App\Models\Applicant;
use App\Models\JobCounter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalysisService
{
    public function criteriaAnalysis($nameTableCriteria, $joiningTableJob, $analysisSearch, $region, $criteria)
    {
        $query = DB::table($nameTableCriteria);
        $query = $this->buildQueryCriteriaAnalysis(
            $query,
            $criteria,
            $nameTableCriteria,
            $joiningTableJob,
            $analysisSearch,
            $region
        );
        return $query->get()->toArray();
    }

    protected function buildQueryCriteriaAnalysis(
        $query,
        $criteria,
        $nameTableCriteria,
        $joiningTableJob,
        $analysisSearch,
        $region
    ) {

        $query = $query->select(
            $nameTableCriteria . ".*",
            DB::raw("sum(views) as sum")
        )
            ->leftJoin($joiningTableJob, $joiningTableJob . "." . $criteria . '_id', $nameTableCriteria . ".id")
            ->join("job_counters", "job_counters.job_id", $joiningTableJob . ".job_id");
        if (!is_null($region)) {
            $listPrefectureId = $region->prefectures()->pluck("prefectures.id");
            $query = $query->join("job_prefecture", "job_prefecture.job_id", $joiningTableJob . ".job_id")
                ->whereIn("job_prefecture.prefecture_id", $listPrefectureId);
        }
        if (isset($analysisSearch["time"])) {
            $query = $this->appendQueryDate($query, $analysisSearch);
        }
        $query->groupBy($nameTableCriteria . ".id")
            ->orderBy('sum', 'desc');
        return $query;
    }

    protected function appendQueryDate($query, $params)
    {
        $dateCurrent = Carbon::now(Consts::TIME_ZONE_JAPAN);
        if ((($params["time"] & Consts::THIS_MONTH) > 0) && (($params["time"] & Consts::LAST_MONTH) > 0)) {
            return $query;
        } elseif (($params["time"] & Consts::THIS_MONTH) > 0) {
            $query->where("view_date", ">=", $dateCurrent->startOfMonth()->toDateString());
        } else {
            $query->where("view_date", "<", $dateCurrent->startOfMonth()->toDateString())
                ->where("view_date", ">=", Carbon::parse($dateCurrent)->subMonth()->toDateString());
        }
        return $query;
    }

    public function analyzeOverTime($criteriaTime)
    {
        $resultAnalysis = null;
        switch ($criteriaTime) {
            case "yesterday":
                $yesterday = Carbon::yesterday(Consts::TIME_ZONE_JAPAN);
                $resultAnalysis = DB::table("job_counters")
                    ->select("jobs.*", DB::raw("(sum(views)) as sum"))
                    ->where("view_date", "=", $yesterday->toDateString())
                    ->join("jobs", "jobs.id", "job_counters.job_id")
                    ->groupBy("jobs.id")
                    ->orderBy('sum', 'desc')
                    ->limit(15)
                    ->get();
                break;
            default:
                return [];
                break;
        }
        return $resultAnalysis->toArray();
    }

    public static function getStatisticalAccessYesterday()
    {
        $yesterday = Carbon::yesterday(Consts::TIME_ZONE_JAPAN)->toDateString();
        $statisticalAccess = [];
        $statisticalAccess['job'] = JobCounter::select(DB::raw("sum(views) as totalViews"))
            ->where('view_date', $yesterday)->first();
        $statisticalAccess['applicant'] = Applicant::where('created_at', $yesterday)->count();
        $statisticalAccess['yesterday'] = $yesterday;
        return $statisticalAccess;

    }
}

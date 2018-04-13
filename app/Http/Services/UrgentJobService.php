<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

use App\Consts;
use App\Models\Job;

class UrgentJobService
{
    public function getActiveUrgentJobs($prefectureIds, $limit = 10)
    {
        $CACHE_KEY = 'activeUrgentJobs?prefectureIds='.(implode('|', $prefectureIds)).'&limit='.$limit;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $jobs = Job::select('jobs.id', 'jobs.description', 'jobs.created_at')
            ->where('jobs.is_active', Consts::TRUE)
            ->where('jobs.platform_urgent', Consts::JOB_URGENT_VALID )
            ->join('job_prefecture', 'job_prefecture.job_id', '=', 'jobs.id')
            ->whereIn('job_prefecture.prefecture_id', $prefectureIds)
            ->distinct()
            ->limit($limit)
            ->get();

        Cache::put($CACHE_KEY, $jobs, $CACHE_DURATION);

        return $jobs;
    }
}

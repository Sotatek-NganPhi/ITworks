<?php

namespace App\Http\Services;

use App\Consts;
use App\Models\Interview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InterviewService
{
    public function __construct()
    {
        $this->today = Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString();
    }

    public function getListInterview($limit, $regionKey)
    {
        $interviews = Interview::select('interviews.id', 'interviews.title', 'interviews.sub_content', 'interviews.thumbnail', 'category_interviews.title as cat_title')
                                ->join('interview_region', 'interview_region.interview_id', '=', 'interviews.id')
                                ->join('regions', 'interview_region.region_id', '=', 'regions.id')
                                ->join('category_interviews', 'category_interviews.id', '=', 'interviews.category_interview_id')
                                ->where('regions.key', $regionKey)
                                ->where('post_start_date', '<=', $this->today)
                                ->where('post_end_date', '>=', $this->today)
                                ->paginate($limit);
        return $interviews;
    }

    public function getInterviewById($id)
    {
        $interview = Interview::with(['categoryInterview'])
                                ->where('id', $id)
                                ->where('post_start_date', '<=', $this->today)
                                ->where('post_end_date', '>=', $this->today)
                                ->first();
        return $interview;
    }

    public function getListByCategory($categoryInterviewId, $limit, $regionKey)
    {
        $interviews = Interview::with(['categoryInterview'])
                                ->select('interviews.id', 'interviews.title', 'interviews.sub_content', 'interviews.thumbnail', 'category_interviews.title as cat_title')
                                ->join('interview_region', 'interview_region.interview_id', '=', 'interviews.id')
                                ->join('regions', 'interview_region.region_id', '=', 'regions.id')
                                ->join('category_interviews', 'category_interviews.id', '=', 'interviews.category_interview_id')
                                ->where('regions.key', $regionKey)
                                ->where('category_interview_id', $categoryInterviewId)
                                ->where('post_start_date', '<=', $this->today)
                                ->where('post_end_date', '>=', $this->today)
                                ->paginate($limit);
        return $interviews;
    }
}

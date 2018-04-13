<?php

namespace App\Http\Services;

use App\Models\Job;
use App\Models\UserBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BookmarkService
{
    public function getUserBookmark(Request $request)
    {
        $user = $request->user();
        $jobs = UserBookmark::where('user_id', $user->id)
            ->join('jobs', 'jobs.id', 'user_bookmarks.job_id')
            ->paginate(10);
        return $jobs;
    }

    public function deleteBookmark(Request $request, Job $job)
    {
        DB::beginTransaction();
        try {
            $user = $request->user();
            UserBookmark::where('user_id', $user->id)
                ->where('job_id', $job->id)
                ->delete();
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

}
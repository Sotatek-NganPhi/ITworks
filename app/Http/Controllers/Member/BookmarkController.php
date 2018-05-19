<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Services\BookmarkService;
use App\Models\Job;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    protected $bookmarkService;

    public function __construct(BookmarkService $bookmarkService)
    {
        $this->bookmarkService = $bookmarkService;
    }

    public function showBookmarkPage(Request $request)
    {
        $jobs = $this->bookmarkService->getUserBookmark($request);
        return view('app.member.bookmark_list', ['jobs' => $jobs]);
    }

    public function deleteBookmark(Request $request, Job $job)
    {
        $this->bookmarkService->deleteBookmark($request, $job);
        return redirect()->route('member_clip_list');
    }
}

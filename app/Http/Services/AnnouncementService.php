<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

use App\Consts;
use App\Models\Announcement;

class AnnouncementService
{
    public function getActiveAnnouncements($regionId)
    {
        $CACHE_KEY = 'activeAnnouncements?regionId='.$regionId;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $today = Carbon::now(Consts::TIME_ZONE_VIETNAM)->toDateString();
        $announcements = Announcement::from('announcements as a')
                            ->join('announcement_region as ar', 'a.id', '=', 'ar.announcement_id')
                            ->where('is_active', Consts::TRUE)
                            ->where('ar.region_id', $regionId)
                            ->where("start_date", "<=", $today)
                            ->where("end_date", '>', $today)
                            ->inRandomOrder()
                            ->get()
                            ->toArray();
        Cache::put($CACHE_KEY, $announcements, $CACHE_DURATION);

        return $announcements;
    }
}

<?php


namespace App\Http\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Cache;
use App\Consts;

class VideoService
{
    public function getActiveVideos($regionId, $limit=3)
    {
        $CACHE_KEY = 'videos?regionId='.$regionId;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $videos = Video::select('videos.*')
            ->join('region_video', 'region_video.video_id', '=', 'videos.id')
            ->where('region_video.region_id', $regionId)
            ->where('videos.is_active', Consts::TRUE)
            ->distinct()
            ->orderBy('videos.id', 'asc')
            ->limit($limit)
            ->get();

        Cache::put($CACHE_KEY, $videos, $CACHE_DURATION);

        return $videos;
    }
}
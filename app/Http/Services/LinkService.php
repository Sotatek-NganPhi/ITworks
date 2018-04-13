<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Jenssegers\Agent\Agent;

use App\Consts;
use App\Models\Link;

class LinkService
{
    public function getActiveLinks($regionId, $limit=5)
    {
        $CACHE_KEY = 'activeLinks?'
                        .'limit='.$limit;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $results = [];
        $today = date('Y-m-d H:i:s');
        $links = Link::where('is_active', Consts::TRUE)
                        ->where('start_date', '<', $today)
                        ->where('end_date', '>', $today)
                        ->join('link_region','link_id','id')
                        ->where('link_region.region_id','=',$regionId)
                        ->distinct()->orderBy('order_by')
                        ->inRandomOrder()
                        ->limit($limit)
                        ->get();


        foreach ($links as $link) {
            array_push($results, [
                'image' => $link->image,
                'url' => $link->url,
                'name' => $link->link_title,
                'order_by' => $link->order_by,
            ]);
        }

        Cache::put($CACHE_KEY, $results, $CACHE_DURATION);

        return $results;
    }
}

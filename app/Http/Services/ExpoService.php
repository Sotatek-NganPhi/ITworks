<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

use App\Consts;
use App\Models\Expo;

class ExpoService
{
    public function getActiveExpos($regionId, $limit=10)
    {
        $CACHE_KEY = 'activeExpos?regionId='.$regionId;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $now = Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString();
        $expos = Expo::select('expos.id', 'expos.presentation_name', 'expos.date')
                    ->join('expo_region', 'expo_region.expo_id', '=', 'expos.id')
                    ->where('expo_region.region_id', $regionId)
                    ->where('expos.is_active', Consts::TRUE)
                    ->where('expos.start_date', '<', $now)
                    ->where('expos.end_date', '>', $now)
                    ->distinct()
                    ->limit($limit)
                    ->get();

        Cache::put($CACHE_KEY, $expos, $CACHE_DURATION);

        return $expos;
    }
}

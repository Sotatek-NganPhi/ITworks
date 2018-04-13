<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

use App\Consts;
use App\Models\Campaign;

class CampaignService
{
    public function getActiveCampain()
    {
        $CACHE_KEY = 'activeCampaign';
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $now = Carbon::now(Consts::TIME_ZONE_JAPAN)->timestamp;
        $campaign = Campaign::select('id', 'banner_path')
            ->where('is_active', Consts::TRUE)
            ->where('start_at', '<', $now)
            ->where('end_at', '>', $now)
            ->first();

        Cache::put($CACHE_KEY, $campaign, $CACHE_DURATION);

        return $campaign;
    }
}

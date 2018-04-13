<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Jenssegers\Agent\Agent;

use App\Consts;
use App\Models\Pickup;
use App\Models\Merit;

class PickupService
{
    public function getActivePickups($keyRegion, $limit=6)
    {
        $CACHE_KEY = 'activePickups?'
                        .'keyRegion='.$keyRegion
                        .'&limit='.$limit;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }
        $now = Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString();
        $results = [];
        $pickups = Pickup::where('is_active', Consts::TRUE)
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->limit($limit)->get();

        $pickupIds = $pickups->pluck('id')->toArray();
        $pickupMerits = DB::table('pickup_merit')
                            ->select('pickup_id', 'merit_id')
                            ->whereIn('pickup_id', $pickupIds)
                            ->get()
                            ->groupBy('pickup_id');

        $pickupCategories = DB::table('pickup_category_level3')
                            ->select('pickup_id', 'category_level3_id')
                            ->whereIn('pickup_id', $pickupIds)
                            ->get()
                            ->groupBy('pickup_id');

        foreach ($pickups as $pickup) {
            $result = [
                'title' => $pickup->title,
                'description' => mb_strlen($pickup->description, 'UTF-8') > 108 ?
                    mb_strcut($pickup->description, 0, 104, 'UTF-8') . '...' : $pickup->description,
                'image' => $pickup->image,
                'link' => route('search', $keyRegion),
            ];

            if ($pickup->match_condition == Consts::PICKUP_CONDITION_MERIT) {
                if (!isset($pickupMerits[$pickup->id])) {
                    continue;
                }

                $meritIds = $pickupMerits[$pickup->id]->pluck('merit_id')->toArray();
                if (count($meritIds) > 0) {
                    $result['link'] = route('search', $keyRegion).'?merits='.(implode(',', $meritIds));
                }
            } elseif ($pickup->match_condition == Consts::PICKUP_CONDITION_CATEGORY) {
                if (!isset($pickupCategories[$pickup->id])) {
                    continue;
                }

                $categoryIds = $pickupCategories[$pickup->id]->pluck('category_level3_id')->toArray();
                if (count($categoryIds) > 0) {
                    $result['link'] = route('search', $keyRegion).'?category='.$categoryIds[0];
                }
            }

            array_push($results, $result);
        }

        Cache::put($CACHE_KEY, $results, $CACHE_DURATION);

        return $results;
    }
}
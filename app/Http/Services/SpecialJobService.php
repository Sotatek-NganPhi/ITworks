<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Config;
use App\Consts;
use App\Models\SpecialPromotion;

class SpecialJobService
{
    public function getElementSpecial($id)
    {
        $query["jobs"] = SpecialPromotion::join('job_special', 'special_promotions.id', '=', 'job_special.special_promotion_id')
                ->join('jobs', 'job_special.job_id', '=', 'jobs.id')
                ->join('companies', 'jobs.company_id', '=', 'companies.id')
                ->select(
                    'special_promotions.name as special_name',
                    'jobs.id as job_id',
                    'jobs.description',
                    'jobs.post_start_date',
                    'jobs.post_end_date',
                    'jobs.application_condition',
                    'jobs.main_image',
                    'jobs.salary',
                    'companies.name as company_name'
                )
                ->where('special_promotions.id', '=', $id)
                ->paginate(10);

        $query["site_name"] = Config::getConfigValue("site_name");
        $query["pc_site_title"] = Config::getConfigValue("pc_site_title");
        $query["image"] = Config::getConfigValue("image");
        return $query;
    }

    public function getActiveSpecialPromotions($regionId, $limit = 2)
    {
        $CACHE_KEY = 'activeSpecials?regionId='.$regionId;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }
        $now = Carbon::now(Consts::TIME_ZONE_VIETNAM)->toDateString();
        //get special by regions and platform and have a least 1 jobs.
        $specialPromotions = SpecialPromotion::from('special_promotions as sp')
            ->select('sp.id', 'sp.image as image', 'sp.name')
            ->join('job_special as js', 'js.special_promotion_id', 'sp.id')
            ->where('sp.is_active', Consts::TRUE)
            ->where('sp.start_date','<',$now)
            ->where('sp.end_date','>',$now)
            ->join('special_promotion_region as spr', 'sp.id', 'spr.special_promotion_id')
            ->where('spr.region_id', $regionId)
            ->distinct()
            ->limit($limit)
            ->get();

        Cache::put($CACHE_KEY, $specialPromotions, $CACHE_DURATION);

        return $specialPromotions;
    }
}

<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests\API\CreateMasterdataAPIRequest;
use App\Http\Requests\API\UpdateMasterdataAPIRequest;
use App\Models\Prefecture;
use App\Models\Foundation\VersionedModel as VersionedModel;
/**
 * Class Region
 * @package App\Models
 * @version June 13, 2017, 4:49 pm UTC
 */
class Region extends VersionedModel
{

    public $table = 'regions';
    public static $tablename = 'regions';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'key',
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'key' => 'required',
        'display_order' => 'required|numeric|min:0',
        'prefectures' => 'required|exists:prefectures,id',
    ];

    public function customUpdate(UpdateMasterdataAPIRequest $request)
    {
        $regionId = $this->id;
        $prefectureIds = isset($request['prefectures']) ? $request['prefectures'] : [];
        Prefecture::where('region_id', $regionId)->update(['region_id' => 0]);
        Prefecture::whereIn('id', $prefectureIds)->update(['region_id' => $regionId]);
        $this->update($request->all());
        return ['success' => true];
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function prefectures()
    {
        return $this->hasMany(Prefecture::class);
    }

    public static function getRegionByKey($key)
    {
        return self::findWhere('key', $key)->first();
    }

    public static function getPrefectureIds($regionId)
    {
        $region = self::findOneById($regionId);
        $listPrefecture = Prefecture::getAll();
        return $listPrefecture->where('region_id', $region->id)->pluck('id')->toArray();
    }
    public static function getPrefectures($regionId)
    {
        $region = self::findOneById($regionId);
        $listPrefecture = Prefecture::getAll();
        return $listPrefecture->where('region_id', $region->id)->toArray();
    }
}

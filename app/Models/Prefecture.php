<?php

namespace App\Models;

use App\Http\Requests\API\UpdateMasterdataAPIRequest;
use Illuminate\Support\Facades\Log;

use App\Extensions\HasManySyncable;
use App\Models\Job;
use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Prefecture
 * @package App\Models
 * @version June 13, 2017, 4:46 pm UTC
 */
class Prefecture extends VersionedModel
{
    public $table = 'prefectures';
    public static $tablename = 'prefectures';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'region_id',
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'region_id' => 'integer',
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
        'wards' => 'required|exists:wards,id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }

    public function customUpdate(UpdateMasterdataAPIRequest $request)
    {
        $prefectureId = $this->id;
        if(!$request->has('wards')) {
            return [
                'success' => false,
                'message' => 'Update failed',
            ];
        }
        $wardIds = $request->input('wards');
        Ward::where('prefecture_id', $prefectureId)->update(['prefecture_id' => 0]);
        Ward::whereIn('id', $wardIds)->update(['prefecture_id' => $prefectureId]);
        $this->update($request->all());
        return ['success' => true];
    }

    public static function getPrefecturesWithRegionKey()
    {
        $regions = Region::getAll()->groupBy('id')->toArray();
        $prefectures = self::getAll()->filter(function ($prefecture, $key) {
                return !empty($prefecture->region_id);
            })->toArray();
        return array_map(function($prefecture) use ($regions) {
                $prefecture = (array) $prefecture;
                $region = (array) $regions[$prefecture["region_id"]][0];
                $regionKey = $region["key"];
                return [
                    'id' => $prefecture["id"],
                    'name' => $prefecture["name"],
                    'link' => route('search', $regionKey) . '?prefecture_id=' . $prefecture["id"],
                ];
        }, $prefectures);
    }
}

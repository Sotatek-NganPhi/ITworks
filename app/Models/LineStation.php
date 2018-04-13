<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class LineStation
 * @package App\Models
 * @version June 13, 2017, 5:33 pm UTC
 */
class LineStation extends VersionedModel
{

    public $table = 'line_stations';
    public static $tablename = 'line_stations';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'line_id',
        'station_id',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'line_id' => 'integer',
        'station_id' => 'integer',
        'order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}

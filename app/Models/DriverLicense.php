<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class DriverLicense
 * @package App\Models
 * @version June 25, 2017, 6:11 am UTC
 */
class DriverLicense extends VersionedModel
{

    public $table = 'driver_licenses';
    public static $tablename = 'driver_licenses';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

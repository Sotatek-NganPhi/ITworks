<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class WorkingPeriod
 * @package App\Models
 * @version June 13, 2017, 9:38 pm UTC
 */
class WorkingPeriod extends VersionedModel
{

    public $table = 'working_periods';
    public static $tablename = 'working_periods';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
        'is_active'
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
        'name' => 'required',
    ];
}

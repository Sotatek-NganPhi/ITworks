<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class RailwayLine
 * @package App\Models
 * @version June 13, 2017, 5:23 pm UTC
 */
class RailwayLine extends VersionedModel
{
    public $table = 'railway_lines';
    public static $tablename = 'railway_lines';
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
    public static $rules = [];
}

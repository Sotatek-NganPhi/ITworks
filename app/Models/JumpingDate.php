<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class JumpingDate
 * @package App\Models
 * @version June 25, 2017, 6:09 am UTC
 */
class JumpingDate extends VersionedModel
{

    public $table = 'jumping_dates';
    public static $tablename = 'jumping_dates';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

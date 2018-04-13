<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class JumpingCondition
 * @package App\Models
 * @version June 25, 2017, 6:08 am UTC
 */
class JumpingCondition extends VersionedModel
{

    public $table = 'jumping_conditions';
    public static $tablename = 'jumping_conditions';
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

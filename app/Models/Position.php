<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Position
 * @package App\Models
 * @version June 25, 2017, 6:09 am UTC
 */
class Position extends VersionedModel
{

    public $table = 'positions';
    public static $tablename = 'positions';
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

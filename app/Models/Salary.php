<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Salary
 * @package App\Models
 * @version June 13, 2017, 5:46 pm UTC
 */
class Salary extends VersionedModel
{

    public $table = 'salaries';
    public static $tablename = 'salaries';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'description',
        'is_active'
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
        'description' => 'required',
    ];
}

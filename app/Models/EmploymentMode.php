<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class EmploymentMode
 * @package App\Models
 * @version June 12, 2017, 7:43 am UTC
 */
class EmploymentMode extends VersionedModel
{
    public $table = 'employment_modes';
    public static $tablename = 'employment_modes';
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
        'description' => 'string',
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

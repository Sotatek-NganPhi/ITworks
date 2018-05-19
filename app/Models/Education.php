<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Education
 * @package App\Models
 * @version June 25, 2017, 6:07 am UTC
 */
class Education extends VersionedModel
{

    public $table = 'educations';
    public static $tablename = 'educations';
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

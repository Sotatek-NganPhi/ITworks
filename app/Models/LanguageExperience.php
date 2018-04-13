<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class LanguageExperience
 * @package App\Models
 * @version June 25, 2017, 12:32 pm UTC
 */
class LanguageExperience extends VersionedModel
{

    public $table = 'language_experiences';
    public static $tablename = 'language_experiences';
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

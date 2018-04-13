<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CompanySize
 * @package App\Models
 * @version June 25, 2017, 6:10 am UTC
 */
class CompanySize extends VersionedModel
{

    public $table = 'company_sizes';
    public static $tablename = 'company_sizes';
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

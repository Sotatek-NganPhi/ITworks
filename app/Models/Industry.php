<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Industry
 * @package App\Models
 * @version June 25, 2017, 6:11 am UTC
 */
class Industry extends VersionedModel
{

    public $table = 'industries';
    public static $tablename = 'industries';
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

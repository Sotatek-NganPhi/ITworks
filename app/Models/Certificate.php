<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Certigicat
 * @package App\Models
 * @version
 */

class Certificate extends VersionedModel
{
    public $table = 'certificates';
    public static $tablename = 'certificates';
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

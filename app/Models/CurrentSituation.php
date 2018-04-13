<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CurrentSituation
 * @package App\Models
 * @version June 21, 2017, 4:57 am UTC
 */
class CurrentSituation extends VersionedModel
{

    public $table = 'current_situations';
    public static $tablename = 'current_situations';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'id',
        'name',
        'is_active',
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
        'name' => 'required',
    ];
}

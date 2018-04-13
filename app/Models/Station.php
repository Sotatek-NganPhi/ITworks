<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Station
 * @package App\Models
 * @version June 13, 2017, 5:26 pm UTC
 */
class Station extends VersionedModel
{

    public $table = 'stations';
    public static $tablename = 'stations';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
        'ward_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'ward_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

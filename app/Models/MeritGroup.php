<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class MeritGroup
 * @package App\Models
 * @version June 20, 2017, 3:45 am UTC
 */
class MeritGroup extends VersionedModel
{

    public $table = 'merit_groups';
    public static $tablename = 'merit_groups';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
        'display_order',
        'search_operator',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'display_order' => 'integer',
        'search_operator' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

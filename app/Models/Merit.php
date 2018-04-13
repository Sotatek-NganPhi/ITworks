<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Merit
 * @package App\Models
 * @version June 20, 2017, 3:42 am UTC
 */
class Merit extends VersionedModel
{
    public $table = 'merits';
    public static $tablename = 'merits';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
        'display_order',
        'merit_group_id',
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
        'merit_group_id' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function pickups()
    {
        return $this->belongsToMany(Pickup::class);
    }
}

<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CategoryLevel2
 * @package App\Models
 * @version June 19, 2017, 5:51 pm UTC
 */
class CategoryLevel2 extends VersionedModel
{

    public $table = 'category_level2s';
    public static $tablename = 'category_level2s';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
        'category_level1_id',
        'display_order',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_level1_id' => 'integer',
        'display_order' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
      'name' => 'required',
      'display_order' => 'numeric|min:0|required'
    ];

    public function categoryLevel3s()
    {
        return $this->hasMany(CategoryLevel3::class);
    }

    public function pickups()
    {
        return $this->belongsToMany(Pickup::class);
    }
}

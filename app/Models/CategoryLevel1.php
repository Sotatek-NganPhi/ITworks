<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CategoryLevel1
 * @package App\Models
 * @version June 19, 2017, 5:50 pm UTC
 */
class CategoryLevel1 extends VersionedModel
{

    public $table = 'category_level1s';
    public static $tablename = 'category_level1s';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name',
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

    public function categoryLevel2s()
    {
        return $this->hasMany(CategoryLevel2::class);
    }
}

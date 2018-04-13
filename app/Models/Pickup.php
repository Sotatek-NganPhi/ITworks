<?php

namespace App\Models;

use App\Extensions\HasManySyncable;
use Eloquent as Model;

/**
 * Class Pickup
 * @package App\Models
 * @version June 21, 2017, 8:13 am UTC
 */
class Pickup extends Model
{

    public $table = 'pickups';

    public $fillable = [
        'id',
        'type',
        'match_condition',
        'title',
        'description',
        'platform',
        'image',
        'image_pc',
        'image_mobile',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'integer',
        'match_condition' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'platform' => 'integer',
        'image' => 'string',
        'image_pc' => 'string',
        'image_mobile' => 'string',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
      'id' => 'integer',
      'type' => 'integer',
      'match_condition' => 'integer',
      'title' => 'string|max:100',
      'description' => 'string',
      'platform' => 'nullable|numeric|min:1',
      'image' => 'string|nullable',
      'image_pc' => 'string|nullable',
      'image_mobile' => 'string|nullable',
      'start_date' => 'date|nullable',
      'end_date' => 'date|after:start_date|nullable',
      'item' => 'integer',
      'is_active' => 'integer',
      'category_level3s' => 'array|exists:category_level3s,id',
      'merits' => 'array|exists:merits,id'
    ];

    public function categoryLevel1s()
    {
        return $this->belongsToMany(CategoryLevel1::class, 'pickup_category_level1');
    }

    public function categoryLevel2s()
    {
        return $this->belongsToMany(CategoryLevel2::class, 'pickup_category_level2');
    }

    public function category_level3s()
    {
        return $this->belongsToMany(CategoryLevel3::class, 'pickup_category_level3');
    }

    public function merits()
    {
        return $this->belongsToMany(Merit::class, 'pickup_merit');
    }
}

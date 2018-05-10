<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class SpecialPromotion
 * @package App\Models
 * @version June 19, 2017, 9:51 am UTC
 */
class SpecialPromotion extends Model
{
    public $table = 'special_promotions';

    public $fillable = [
        'id',
        'name',
        'image',
        'image_pc',
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
        'name' => 'string',
        'image_pc' => 'string',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:200',
        'image' => 'string',
        'image_pc' => 'string',
        'image_mobile' => 'string',
        'is_active' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date|after:start_date',
        'regions' => 'array|exists:regions,id',
        'jobs' => 'array|exists:jobs,id'
    ];

    public function getStartDateAttribute($value)
    {
        return date('m-d-Y', strtotime($value));
    }

    public function getEndDateAttribute($value)
    {
        return date('m-d-Y', strtotime($value));
    }

    public function regions()
    {
        return $this->belongsToMany('App\Models\Region', 'special_promotion_region')->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job', 'job_special')->withTimestamps();
    }
}

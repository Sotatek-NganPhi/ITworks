<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\Region;

/**
 * Class Link
 * @package App\Models
 * @version June 19, 2017, 7:32 am UTC
 */
class Link extends Model
{

    public $table = 'links';

    public $fillable = [
        'id',
        'link_title',
        'url_pc',
        'url_mobile',
        'url',
        'image',
        'order_by',
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
        'link_title' => 'string',
        'url_pc' => 'string',
        'url_mobile' => 'string',
        'image_pc' => 'string',
        'image_mobile' => 'string',
        'order_by' => 'integer',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'link_title' => 'string',
        'url_pc' => 'nullable|url',
        'url_mobile' => 'nullable|url',
        'image_pc' => 'nullable|string',
        'image_mobile' => 'nullable|string',
        'image' => 'string',
        'url' => 'url',
        'order_by' => 'numeric|min:1',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date|after:start_date',
        'regions'  => 'array|exists:regions,id'
    ];

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'link_region', 'link_id', 'region_id');
    }
}

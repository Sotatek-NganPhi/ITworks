<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Announcement
 * @package App\Models
 * @version July 24, 2017, 6:42 am UTC
 */
class Announcement extends Model
{

    public $table = 'announcements';

    public $fillable = [
        'id',
        'content',
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
        'id' => 'integer',
        'content' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'numeric'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content'    => 'string',
        'start_date' => 'date',
        'end_date'   => 'date|after:start_date',
        'is_active'  => 'boolean',
        'regions' => 'array|exists:regions,id'
    ];

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }
}

<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;

/**
 * Class Campaign
 * @package App\Models
 * @version June 23, 2017, 8:51 am UTC
 */
class Campaign extends Model
{

    public $table = 'campaigns';

    public $fillable = [
        'id',
        'title',
        'content',
        'banner_path',
        'start_at',
        'end_at',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'content' => 'string',
        'banner_path' => 'string',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'string',
        'start_at' => 'date',
        'end_at' => 'date|after:start_at',
        'content' => 'string',
        'banner_path' => 'string',
        'is_active' => 'numeric'
    ];

    public function getStartAtAttribute()
    {
        return Carbon::createFromTimestamp($this->attributes['start_at'])->format('Y-m-d H:i:s');
    }

    public function getEndAtAttribute()
    {
        return Carbon::createFromTimestamp($this->attributes['end_at'])->format('Y-m-d H:i:s');
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::parse($value)->timestamp;
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::parse($value)->timestamp;
    }
}

<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Expo
 * @package App\Models
 * @version June 21, 2017, 7:58 am UTC
 */
class Expo extends Model
{
    public $table = 'expos';

    public $fillable = [
        'date',
        'organizer_name',
        'time',
        'start_date',
        'end_date',
        'presentation_name',
        'address',
        'content',
        'pr',
        'map_url',
        'cs_email',
        'cs_phone',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'organizer_name' => 'string',
        'time' => 'string',
        'presentation_name' => 'string',
        'address' => 'string',
        'content' => 'string',
        'pr' => 'string',
        'map_url' => 'string',
        'cs_email' => 'string',
        'cs_phone' => 'string',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
      'id' => 'numeric:min0',
      'organizer_name' => 'string',
      'time' => 'string',
      'date' => 'date',
      'start_date' => 'date',
      'end_date' => 'date|after:start_date',
      'presentation_name' => 'string',
      'address' => 'string',
      'content' => 'string',
      'map_url' => 'url',
      'cs_email' => 'email',
      'regions' => 'array|exists:regions,id'
    ];

    public function regions()
    {
        return $this->belongsToMany('App\Models\Region');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
}

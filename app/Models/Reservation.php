<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Reservation
 * @package App\Models
 * @version June 22, 2017, 7:49 am UTC
 */
class Reservation extends Model
{

    public $fillable = [
        'surname',
        'name',
        'surname_phonetic',
        'gender',
        'email',
        'phone_number',
        'agreed_to_policy',
        'full_name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'surname' => 'string',
        'name' => 'string',
        'surname_phonetic' => 'string',
        'gender' => 'integer',
        'email' => 'string',
        'phone_number' => 'string',
        'agreed_to_policy' => 'boolean',
        'full_name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

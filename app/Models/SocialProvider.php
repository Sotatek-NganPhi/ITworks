<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class SocialProvider
 * @package App\Models
 * @version June 22, 2017, 5:47 am UTC
 */
class SocialProvider extends Model
{

    public $table = 'social_providers';

    public $fillable = [
        'user_id',
        'provider',
        'provider_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'provider' => 'string',
        'provider_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

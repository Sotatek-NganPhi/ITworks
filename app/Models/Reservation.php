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

    public $table = 'expo_reservations';

    public $fillable = [
        'expo_id',
        'surname',
        'name',
        'surname_phonetic',
        'name_phonetic',
        'gender',
        'email',
        'current_situation_id',
        'phone_number',
        'agreed_to_policy',
        'full_name',
        'full_name_phonetic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'expo_id' => 'integer',
        'surname' => 'string',
        'name' => 'string',
        'surname_phonetic' => 'string',
        'name_phonetic' => 'string',
        'gender' => 'integer',
        'email' => 'string',
        'current_situation_id' => 'integer',
        'phone_number' => 'string',
        'agreed_to_policy' => 'boolean',
        'full_name' => 'string',
        'full_name_phonetic' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function currentSituation()
    {
        return $this->belongsTo('App\Models\CurrentSituation');
    }
}

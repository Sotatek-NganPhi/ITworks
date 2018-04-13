<?php

namespace App\Repositories;

use App\Models\Reservation;
use InfyOm\Generator\Common\BaseRepository;

class ReservationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'expo_id',
        'surname' => 'like',
        'name' => 'like',
        'surname_phonetic' => 'like',
        'name_phonetic' => 'like',
        'gender',
        'email',
        'current_situation_id',
        'phone_number' => 'like',
        'agreed_to_policy',
        'full_name' => 'like',
        'full_name_phonetic' => 'like'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Reservation::class;
    }
}

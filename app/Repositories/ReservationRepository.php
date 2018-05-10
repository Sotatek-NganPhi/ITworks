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
        'surname' => 'like',
        'name' => 'like',
        'surname_phonetic' => 'like',
        'gender',
        'email',
        'phone_number' => 'like',
        'agreed_to_policy',
        'full_name' => 'like',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Reservation::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Expo;
use InfyOm\Generator\Common\BaseRepository;

class ExpoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'date',
        'organizer_name',
        'time',
        'start_date' => '>=',
        'end_date' => '<=',
        'presentation_name' => 'like',
        'address' => 'like',
        'content' => 'like',
        'pr' => 'like',
        'map_url',
        'cs_email' => 'like',
        'cs_phone',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expo::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Pickup;
use InfyOm\Generator\Common\BaseRepository;

class PickupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'match_condition',
        'title',
        'description',
        'platform',
        'image',
        'image_pc',
        'image_mobile',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pickup::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Station;
use InfyOm\Generator\Common\BaseRepository;

class StationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'ward_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Station::class;
    }
}

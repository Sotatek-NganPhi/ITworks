<?php

namespace App\Repositories;

use App\Models\RailwayLine;
use InfyOm\Generator\Common\BaseRepository;

class RailwayLineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RailwayLine::class;
    }
}

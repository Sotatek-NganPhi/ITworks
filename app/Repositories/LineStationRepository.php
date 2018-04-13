<?php

namespace App\Repositories;

use App\Models\LineStation;
use InfyOm\Generator\Common\BaseRepository;

class LineStationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'line_id',
        'station_id',
        'order'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LineStation::class;
    }
}

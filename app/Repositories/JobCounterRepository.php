<?php

namespace App\Repositories;

use App\Models\JobCounter;
use InfyOm\Generator\Common\BaseRepository;

class JobCounterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_id',
        'views'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobCounter::class;
    }
}

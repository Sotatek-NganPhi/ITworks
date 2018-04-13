<?php

namespace App\Repositories;

use App\Models\Industry;
use InfyOm\Generator\Common\BaseRepository;

class IndustryRepository extends BaseRepository
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
        return Industry::class;
    }
}

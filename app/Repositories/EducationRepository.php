<?php

namespace App\Repositories;

use App\Models\Education;
use InfyOm\Generator\Common\BaseRepository;

class EducationRepository extends BaseRepository
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
        return Education::class;
    }
}

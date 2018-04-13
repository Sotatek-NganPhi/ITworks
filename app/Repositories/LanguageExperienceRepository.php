<?php

namespace App\Repositories;

use App\Models\LanguageExperience;
use InfyOm\Generator\Common\BaseRepository;

class LanguageExperienceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LanguageExperience::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\EmploymentMode;
use InfyOm\Generator\Common\BaseRepository;

class EmploymentModeRepository extends BaseRepository
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
        return EmploymentMode::class;
    }
    public function rules()
    {
        return EmploymentMode::$rules;
    }
}

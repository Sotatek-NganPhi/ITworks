<?php

namespace App\Repositories;

use App\Models\WorkingHour;
use InfyOm\Generator\Common\BaseRepository;

class WorkingHourRepository extends BaseRepository
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
        return WorkingHour::class;
    }

    public function rules()
    {
        return WorkingHour::$rules;
    }
}

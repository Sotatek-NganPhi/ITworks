<?php

namespace App\Repositories;

use App\Models\WorkingPeriod;
use InfyOm\Generator\Common\BaseRepository;

class WorkingPeriodRepository extends BaseRepository
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
        return WorkingPeriod::class;
    }

    public function rules()
    {
        return WorkingPeriod::$rules;
    }
}

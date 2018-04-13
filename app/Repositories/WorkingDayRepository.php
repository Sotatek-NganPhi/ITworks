<?php

namespace App\Repositories;

use App\Models\WorkingDay;
use InfyOm\Generator\Common\BaseRepository;

class WorkingDayRepository extends BaseRepository
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
        return WorkingDay::class;
    }
    
    public function rules()
    {
        return WorkingDay::$rules;
    }
}

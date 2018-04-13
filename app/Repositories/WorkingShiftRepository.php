<?php

namespace App\Repositories;

use App\Models\WorkingShift;
use InfyOm\Generator\Common\BaseRepository;

class WorkingShiftRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WorkingShift::class;
    }

    public function rules()
    {
        return WorkingShift::$rules;
    }
}

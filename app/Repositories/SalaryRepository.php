<?php

namespace App\Repositories;

use App\Models\Salary;
use InfyOm\Generator\Common\BaseRepository;

class SalaryRepository extends BaseRepository
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
        return Salary::class;
    }

    public function rules()
    {
        return Salary::$rules;
    }
}

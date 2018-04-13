<?php

namespace App\Repositories;

use App\Models\JumpingCondition;
use InfyOm\Generator\Common\BaseRepository;

class JumpingConditionRepository extends BaseRepository
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
        return JumpingCondition::class;
    }
}

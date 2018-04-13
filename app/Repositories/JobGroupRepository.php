<?php

namespace App\Repositories;

use App\Models\JobGroup;
use InfyOm\Generator\Common\BaseRepository;

class JobGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'parent_id',
        'level',
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobGroup::class;
    }
}

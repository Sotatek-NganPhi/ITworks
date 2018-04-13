<?php

namespace App\Repositories;

use App\Models\JumpingDate;
use InfyOm\Generator\Common\BaseRepository;

class JumpingDateRepository extends BaseRepository
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
        return JumpingDate::class;
    }
}

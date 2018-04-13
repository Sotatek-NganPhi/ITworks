<?php

namespace App\Repositories;

use App\Models\Ward;
use InfyOm\Generator\Common\BaseRepository;

class WardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'prefecture_id',
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ward::class;
    }
}

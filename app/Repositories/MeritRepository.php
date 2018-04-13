<?php

namespace App\Repositories;

use App\Models\Merit;
use InfyOm\Generator\Common\BaseRepository;

class MeritRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_order',
        'merit_group_id',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Merit::class;
    }
}

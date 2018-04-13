<?php

namespace App\Repositories;

use App\Models\MeritGroup;
use InfyOm\Generator\Common\BaseRepository;

class MeritGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_order',
        'search_operator',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MeritGroup::class;
    }
}

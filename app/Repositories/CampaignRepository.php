<?php

namespace App\Repositories;

use App\Models\Campaign;
use InfyOm\Generator\Common\BaseRepository;

class CampaignRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'title' => 'like',
        'content' => 'like',
        'start_at' => '>=',
        'end_at' => '<=',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Campaign::class;
    }
}

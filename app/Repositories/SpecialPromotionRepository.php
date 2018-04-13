<?php

namespace App\Repositories;

use App\Models\SpecialPromotion;
use InfyOm\Generator\Common\BaseRepository;

class SpecialPromotionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name' => 'like',
        'platform',
        'image',
        'image_pc',
        'image_mobile',
        'start_date' => '>=',
        'end_date' => '<=',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SpecialPromotion::class;
    }
}

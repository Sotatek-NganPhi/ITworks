<?php

namespace App\Repositories;

use App\Models\CategoryLevel2;
use InfyOm\Generator\Common\BaseRepository;

class CategoryLevel2Repository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category_level1_id',
        'display_order',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoryLevel2::class;
    }

    public function rules()
    {
        return CategoryLevel2::$rules;
    }
}

<?php

namespace App\Repositories;

use App\Models\CategoryLevel3;
use InfyOm\Generator\Common\BaseRepository;

class CategoryLevel3Repository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category_level2_id',
        'display_order',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoryLevel3::class;
    }

    public function rules()
    {
        return CategoryLevel3::$rules;
    }
}

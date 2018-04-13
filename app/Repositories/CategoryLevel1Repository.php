<?php

namespace App\Repositories;

use App\Models\CategoryLevel1;
use InfyOm\Generator\Common\BaseRepository;

class CategoryLevel1Repository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_order',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoryLevel1::class;
    }

    public function rules()
    {
        return CategoryLevel1::$rules;
    }
}

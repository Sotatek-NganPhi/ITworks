<?php

namespace App\Repositories;

use App\Models\Prefecture;
use InfyOm\Generator\Common\BaseRepository;

class PrefectureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'region_id',
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Prefecture::class;
    }

    public function rules()
    {
        return Prefecture::$rules;
    }
}

<?php

namespace App\Repositories;

use App\Models\CompanySize;
use InfyOm\Generator\Common\BaseRepository;

class CompanySizeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'min',
        'max'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanySize::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\DriverLicense;
use InfyOm\Generator\Common\BaseRepository;

class DriverLicenseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DriverLicense::class;
    }
}

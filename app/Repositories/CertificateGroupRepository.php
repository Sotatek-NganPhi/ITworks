<?php

namespace App\Repositories;

use App\Models\CertificateGroup;
use InfyOm\Generator\Common\BaseRepository;

class CertificateGroupRepository extends BaseRepository
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
        return CertificateGroup::class;
    }
}

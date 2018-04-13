<?php

namespace App\Repositories;

use App\Models\CandidateCertificate;
use InfyOm\Generator\Common\BaseRepository;

class CandidateCertificateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'certificate_id',
        'candidate_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CandidateCertificate::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\ReferralAgency;
use InfyOm\Generator\Common\BaseRepository;

class ReferralAgencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'code',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReferralAgency::class;
    }

    public function rules()
    {
        return ReferralAgency::$rules;
    }
}
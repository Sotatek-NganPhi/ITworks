<?php

namespace App\Repositories;

use App\Models\SocialProvider;
use InfyOm\Generator\Common\BaseRepository;

class SocialProviderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'provider',
        'provider_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SocialProvider::class;
    }
}

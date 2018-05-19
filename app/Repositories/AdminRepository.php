<?php

namespace App\Repositories;

use App\Manager;
use App\User;
use InfyOm\Generator\Common\BaseRepository;

class AdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username' => 'like',
        'name' => 'like',
        'email' => 'like',
        'id',
        'type',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Manager::class;
    }
}

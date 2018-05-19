<?php

namespace App\Repositories;

use App\Models\Config;
use InfyOm\Generator\Common\BaseRepository;

class ConfigRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'value',
        'display_name',
        'description',
        'input_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Config::class;
    }
}

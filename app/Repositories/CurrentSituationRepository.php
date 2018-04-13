<?php

namespace App\Repositories;

use App\Models\CurrentSituation;
use InfyOm\Generator\Common\BaseRepository;

class CurrentSituationRepository extends BaseRepository
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
        return CurrentSituation::class;
    }

    public function rules()
    {
        return CurrentSituation::$rules;
    }
}

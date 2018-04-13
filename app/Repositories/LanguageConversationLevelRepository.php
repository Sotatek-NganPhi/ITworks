<?php

namespace App\Repositories;

use App\Models\LanguageConversationLevel;
use InfyOm\Generator\Common\BaseRepository;

class LanguageConversationLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LanguageConversationLevel::class;
    }
}

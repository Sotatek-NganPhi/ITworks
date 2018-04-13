<?php

namespace App\Repositories;

use App\Models\Message;
use InfyOm\Generator\Common\BaseRepository;

class MessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'applicant_id',
        'content',
        'title',
        'type',
        'metadata',
        'from',
        'user_id',
        'manager_id',
        'is_read',
        'is_favorite'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Message::class;
    }
}

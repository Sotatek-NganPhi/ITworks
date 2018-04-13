<?php

namespace App\Repositories;

use App\Models\MailLogs;
use InfyOm\Generator\Common\BaseRepository;

class MailLogsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MailLogs::class;
    }
}

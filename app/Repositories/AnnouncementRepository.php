<?php

namespace App\Repositories;

use App\Models\Announcement;

class AnnouncementRepository extends AppBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'content' => 'like',
        'start_date' => '>=',
        'end_date' => '<=',
        'is_active',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Announcement::class;
    }
}

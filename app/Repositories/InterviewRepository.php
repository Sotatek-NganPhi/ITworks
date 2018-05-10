<?php

namespace App\Repositories;

use App\Models\Interview;
use InfyOm\Generator\Common\BaseRepository;

class InterviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'title' => 'like',
        'content' => 'like',
        'sub_content',
        'date' => '>=',
        'post_start_date' => '>=',
        'post_end_date' => '<=',
        'company_name',
        'company_description',
        'category_interview_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Interview::class;
    }
}

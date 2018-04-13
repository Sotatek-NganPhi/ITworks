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
        'picture',
        'thumbnail',
        'content' => 'like',
        'sub_content',
        'date' => '>=',
        'post_start_date' => '>=',
        'post_end_date' => '<=',
        'interviewer' => 'like',
        'company_name',
        'company_description',
        'company_url',
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

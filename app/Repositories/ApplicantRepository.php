<?php

namespace App\Repositories;

use App\Models\Applicant;
use InfyOm\Generator\Common\BaseRepository;

class ApplicantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'job_id',
        'companies.name',
        'jobs.is_active',
        'user_id',
        'status',
        'email',
        'first_name',
        'last_name',
        'gender',
        'phone_number',
        'birthday',
        'prefectures_id',
        'address',
        'recent_school_name',
        'department',
        'guarduation_year',
        'academic_achievement',
        'jobs.post_start_date' => '>=',
        'jobs.post_end_date' => '<=',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Applicant::class;
    }
}

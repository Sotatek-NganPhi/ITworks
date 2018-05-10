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
        'jobs.is_active',
        'user_id',
        'jobs.company_name',
        'status',
        'email',
        'first_name',
        'last_name',
        'furigana_first_name',
        'furigana_last_name',
        'gender',
        'phone_number',
        'birthday',
        'prefectures_id',
        'prefectures_code',
        'address',
        'recent_school_name',
        'department',
        'guarduation_year',
        'academic_achievement',
        'qualification',
        'recent_employment',
        'recent_employment_job',
        'recent_employment_period',
        'pr',
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

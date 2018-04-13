<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Applicant
 * @package App\Models
 * @version June 26, 2017, 3:41 am UTC
 */
class Applicant extends Model
{

    public $table = 'applicants';

    public $fillable = [
        'user_id',
        'job_id',
        'email',
        'first_name',
        'last_name',
        'first_name_phonetic',
        'last_name_phonetic',
        'postal_code',
        'address',
        'phone_number',
        'gender',
        'birthday',
        'current_situation_id',
        'education_id',
        'final_academic_school',
        'graduated_at',
        'toeic',
        'toefl',
        'language_experience_id',
        'language_conversation_level_id',
        'driver_license_id',
        'worked_companies_number',
        'lastest_industry_id',
        'lastest_job_description',
        'resume_pr',
        'lastest_company_name',
        'lastest_position_id',
        'status',
        'lastest_employment_mode_id',
        'is_married',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'job_id' => 'integer',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'first_name_phonetic' => 'string',
        'last_name_phonetic' => 'string',
        'postal_code' => 'string',
        'address' => 'string',
        'phone_number' => 'string',
        'gender' => 'string',
        'birthday' => 'date',
        'current_situation_id' => 'integer',
        'education_id' => 'integer',
        'final_academic_school' => 'string',
        'graduated_at' => 'date',
        'toeic' => 'float',
        'toefl' => 'float',
        'language_experience_id' => 'integer',
        'language_conversation_level_id' => 'integer',
        'driver_license_id' => 'integer',
        'worked_companies_number' => 'integer',
        'lastest_industry_id' => 'integer',
        'lastest_job_description' => 'string',
        'resume_pr' => 'string',
        'lastest_company_name' => 'string',
        'lastest_position_id' => 'integer',
        'status' => 'integer',
        'lastest_employment_mode_id' => 'integer',
        'is_married' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
     public function jobs()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }
}

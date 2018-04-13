<?php

namespace App\Models;

use Eloquent as Model;
use App\User;
use App\Models\Foundation\Criteriable;

/**
 * Class Candidate
 * @package App\Models
 * @version June 25, 2017, 6:15 am UTC
 */
class Candidate extends Model
{
    use Criteriable;

    public $table = 'candidates';

    public $fillable = [
        'platform_flag',
        'is_married',
        'current_situation_id',
        'user_id',
        'final_academic_school',
        'graduated_at',
        'education_id',
        'toeic',
        'toefl',
        'language_experience_id',
        'language_conversation_level_id',
        'driver_license_id',
        'jumping_condition_id',
        'jumping_date_id',
        'worked_companies_number',
        'lastest_company_name',
        'lastest_industry_id',
        'lastest_company_size_id',
        'lastest_annual_income',
        'lastest_position_id',
        'lastest_employment_mode_id',
        'lastest_job_description',
        'resume_prefectures_id',
        'resume_academic_department',
        'resume_academic_achievement',
        'resume_qualification',
        'resume_recent_employment_industry',
        'resume_recent_employment_job',
        'resume_recent_employment_period',
        'resume_pr'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_married' => 'integer',
        'current_situation_id' => 'integer',
        'user_id' => 'integer',
        'education_id' => 'integer',
        'final_academic_school' => 'stringo',
        'graduated_at' => 'datetime',
        'toeic' => 'integer',
        'toefl' => 'integer',
        'language_experience_id' => 'integer',
        'language_conversation_level_id' => 'integer',
        'driver_license_id' => 'integer',
        'jumping_condition_id' => 'integer',
        'worked_companies_number' => 'integer',
        'lastest_company_name' => 'string',
        'lastest_industry_id' => 'integer',
        'lastest_company_size_id' => 'integer',
        'lastest_annual_income' => 'float',
        'lastest_position_id' => 'integer',
        'lastest_employment_mode_id' => 'integer',
        'lastest_job_description' => 'string',
        'jumping_date_id' => 'integer',
        'resume_prefectures_id' => 'integer',
        'resume_academic_department' => 'string',
        'resume_academic_achievement' => 'string',
        'resume_qualification' => 'string',
        'resume_recent_employment_industry' => 'string',
        'resume_recent_employment_job' => 'string',
        'resume_recent_employment_period' => 'string',
        'resume_pr' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'platform_flag' => 'numeric',
        'is_married' => 'nullable|boolean',
        'current_situation_id' => 'exists:current_situations,id',
        'user_id' => 'exists:users,id',
        'graduated_at' => 'nullable|date_format:Y-m-d',
        'toeic' => 'nullable|numeric|min:0',
        'toefl' => 'nullable|numeric|min:0',
        'language_experience_id' => 'exists:language_experiences,id',
        'language_conversation_level_id' => 'nullable|exists:language_conversation_levels,id',
        'driver_license_id' => 'exists:driver_licenses,id|required',
        'jumping_condition_id' => 'nullable|exists:jumping_conditions,id',
        'jumping_date_id' => 'exists:jumping_dates,id',
        'worked_companies_number' => 'numeric|required',
        'lastest_industry_id' => 'exists:industries,id|required',
        'lastest_company_size_id' => 'exists:company_sizes,id|required',
        'lastest_annual_income' => 'numeric|min:0|required',
        'lastest_position_id' => 'exists:positions,id|required',
        'lastest_employment_mode_id' => 'exists:employment_modes,id|required',
        'education_id' => 'required',
        'lastest_company_name' => 'required',
        'category_level_1s.*' => 'exists:category_level1s,id',
        'category_level_2s.*' => 'exists:category_level2s,id',
        'category_level_3s.*' => 'exists:category_level3s,id',
        'company_sizes.*' => 'exists:company_sizes,id',
        'current_situations.*' => 'exists:current_situations,id',
        'employment_modes' => 'exists:employment_modes,id',
        'working_days.*' => 'exists:working_days,id',
        'working_periods.*' => 'exists:working_periods,id',
        'working_hours.*' => 'exists:working_hours,id',
        'working_shifts.*' => 'exists:working_shifts,id',
        'certificates.*' => 'exists:certificates,id',
        'certificate_groups.*' => 'exists:certificate_groups,id',
        'categoryLevel1s.*' => 'exists:category_level1s,id',
        'categoryLevel2s.*' => 'exists:category_level2s,id',
        'categoryLevel3s.*' => 'exists:category_level3s,id',
        'companySizes.*' => 'exists:company_sizes,id',
        'currentSituations.*' => 'exists:current_situations,id',
        'industries.*' => 'exists:industries,id',
        'prefectures' => 'required|array|exists:prefectures,id',
        'salaries.*' => 'exists:salaries,id',
        'workingDays.*' => 'exists:working_days,id',
        'workingPeriods.*' => 'exists:working_periods,id',
        'workingHours.*' => 'exists:working_hours,id',
        'workingShifts.*' => 'exists:working_shifts,id',
        'user.email' => 'sometimes|required|email',
        'user.gender' => 'sometimes|required|in:male,female',
        'user.birthday' => 'sometimes|required|date',
        'user.mail_receivable' => 'sometimes|required|boolean',
        'user.name' => 'sometimes|required',
        'user.name_phonetic' => 'sometimes|required',
        'user.postal_code' => 'sometimes|required',
        'user.address' => 'sometimes|required',
        'user.phone_number' => 'sometimes|required',
    ];

    public function getGraduatedAtAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employmentModes()
    {
        return $this->belongsToMany(EmploymentMode::class, 'candidate_employment_mode', 'candidate_id', 'employment_mode_id');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class);
    }

    public function companySizes()
    {
        return $this->belongsToMany(CompanySize::class);
    }

    public function categoryLevel1s()
    {
        return $this->belongsToMany(CategoryLevel1::class, 'candidate_category_level1', 'candidate_id', 'category_level1_id');
    }

    public function categoryLevel2s()
    {
        return $this->belongsToMany(CategoryLevel2::class, 'candidate_category_level2', 'candidate_id', 'category_level2_id');
    }

    public function categoryLevel3s()
    {
        return $this->belongsToMany(CategoryLevel3::class, 'candidate_category_level3', 'candidate_id', 'category_level3_id');
    }

    public function currentSituations()
    {
        return $this->belongsToMany(CurrentSituation::class, 'candidate_current_situation');
    }

    public function merits()
    {
        return $this->belongsToMany(Merit::class);
    }

    public function salaries()
    {
        return $this->belongsToMany(Salary::class);
    }

    public function prefectures()
    {
        return $this->belongsToMany(Prefecture::class);
    }

    public function workingShifts()
    {
        return $this->belongsToMany(WorkingShift::class);
    }

    public function workingDays()
    {
        return $this->belongsToMany(WorkingDay::class);
    }

    public function workingHours()
    {
        return $this->belongsToMany(WorkingHour::class);
    }

    public function workingPeriods()
    {
        return $this->belongsToMany(WorkingPeriod::class);
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }

    public function reference()
    {
        return $this->hasOne(UserReferences::class, 'user_id', 'user_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'candidate_job_rankings')
            ->withPivot('ranking')
            ->orderBy('pivot_ranking', 'desc');
    }

    public function scopeMailable($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('mail_receivable', '=', 1);
        });
    }
}

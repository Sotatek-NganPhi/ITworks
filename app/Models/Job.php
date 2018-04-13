<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\Foundation\Criteriable;

/**
 * Class job
 * @package App\Models
 * @version June 8, 2017, 12:56 am UTC
 */
class Job extends Model
{
    use Criteriable;

    public $table = 'jobs';

    public $fillable = [
        'id',
        'work_no',
        'company_id',
        'description',
        'company_name',
        'post_type',
        'post_start_date',
        'post_end_date',
        'original_state',
        'max_applicant',
        'work_main',
        'working_hours',
        'seniors_hometown',
        'salary',
        'application_condition',
        'message',
        'interns_start_time',
        'holiday_vacation',
        'interview_place',
        'receptionist',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'option_7',
        'option_8',
        'option_9',
        'option_10',
        'option_11',
        'option_12',
        'option_13',
        'option_14',
        'option_15',
        'option_16',
        'option_17',
        'option_18',
        'option_19',
        'option_20',
        'main_image',
        'main_caption',
        'sub_image1',
        'sub_image2',
        'sub_image3',
        'sub_image4',
        'sub_caption1',
        'sub_caption2',
        'sub_caption3',
        'sub_caption4',
        'email_receive_applicant',
        'email_company',
        'sales_person_mail',
        'remarks',
        'automatic_reply_mail_status',
        'automatic_reply_mail_content',
        'platform_urgent',
        'is_active',
        'agency_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'work_no' => 'string',
        'company_id' => 'integer',
        'description' => 'string',
        'company_name' => 'string',
        'post_start_date' => 'date',
        'post_end_date' => 'date',
        'original_state' => 'string',
        'max_applicant' => 'string',
        'work_main' => 'string',
        'working_hours' => 'string',
        'seniors_hometown' => 'string',
        'salary' => 'string',
        'application_condition' => 'string',
        'message' => 'string',
        'interns_start_time' => 'string',
        'holiday_vacation' => 'string',
        'interview_place' => 'string',
        'receptionist' => 'string',
        'option_1' => 'string',
        'option_2' => 'string',
        'option_3' => 'string',
        'option_4' => 'string',
        'option_5' => 'string',
        'option_6' => 'string',
        'option_7' => 'string',
        'option_8' => 'string',
        'option_9' => 'string',
        'option_10' => 'string',
        'option_11' => 'string',
        'option_12' => 'string',
        'option_13' => 'string',
        'option_14' => 'string',
        'option_15' => 'string',
        'option_16' => 'string',
        'option_17' => 'string',
        'option_18' => 'string',
        'option_19' => 'string',
        'option_20' => 'string',
        'main_image' => 'string',
        'main_caption' => 'string',
        'sub_image1' => 'string',
        'sub_image2' => 'string',
        'sub_image3' => 'string',
        'sub_image4' => 'string',
        'sub_caption1' => 'string',
        'sub_caption2' => 'string',
        'sub_caption3' => 'string',
        'sub_caption4' => 'string',
        'email_receive_applicant' => 'string',
        'email_company' => 'string',
        'sales_person_mail' => 'string',
        'remarks' => 'string',
        'automatic_reply_mail_status' => 'string',
        'automatic_reply_mail_content' => 'string',
        'platform_urgent' => 'integer',
        'is_active' => 'boolean',
        'agency_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company' => 'required|integer|exists:companies,id',
        'company_name' => 'required',
        'description' => 'required',
        'post_start_date' => 'required|date',
        'post_end_date' => 'required|date|after:post_start_date',
        'original_state' => 'required',
        'salary' => 'required',
        'application_condition' => 'required',
        'email_receive_applicant' => 'required|email',
        'categoryLevel3s' => 'required|array|exists:category_level3s,id',
        'prefectures' => 'required|array|exists:prefectures,id',
        'wards' => 'required|array|exists:wards,id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function categoryLevel3s()
    {
        return $this->belongsToMany(CategoryLevel3::class, 'job_category_level3');
    }

    public function currentSituations()
    {
        return $this->belongsToMany(CurrentSituation::class, 'job_current_situation');
    }

    public function merits()
    {
        return $this->belongsToMany(Merit::class);
    }

    public function salaries()
    {
        return $this->belongsToMany(Salary::class);
    }

    public function employmentModes()
    {
        return $this->belongsToMany(EmploymentMode::class, 'job_employment_mode');
    }

    public function prefectures()
    {
        return $this->belongsToMany(Prefecture::class);
    }

    public function wards()
    {
        return $this->belongsToMany(Ward::class);
    }

    public function workingShifts()
    {
        return $this->belongsToMany(WorkingShift::class);
    }

    public function workingDays()
    {
        return $this->belongsToMany(WorkingDay::class);
    }
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function workingHours()
    {
        return $this->belongsToMany(WorkingHour::class);
    }

    public function workingPeriods()
    {
        return $this->belongsToMany(WorkingPeriod::class);
    }

    public function routes()
    {
        return $this->belongsToMany(LineStation::class, 'job_routes', 'job_id', 'line_station_id');
    }

    public function counters()
    {
        return $this->hasMany(JobCounter::class);
    }

    public function specialPromotions()
    {
        return $this->belongsToMany(SpecialPromotion::class, 'job_special');
    }
}

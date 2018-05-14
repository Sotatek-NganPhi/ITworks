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
        'company_id',
        'description',
        'company_name',
        'post_start_date',
        'post_end_date',
        'max_applicant',
        'working_hours',
        'salary',
        'application_condition',
        'message',
        'interns_start_time',
        'main_image',
        'main_caption',
        'email_receive_applicant',
        'email_company',
        'remarks',
        'is_active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'description' => 'string',
        'company_name' => 'string',
        'post_start_date' => 'date',
        'post_end_date' => 'date',
        'max_applicant' => 'string',
        'working_hours' => 'string',
        'salary' => 'string',
        'application_condition' => 'string',
        'message' => 'string',
        'interns_start_time' => 'string',
        'main_image' => 'string',
        'main_caption' => 'string',
        'email_receive_applicant' => 'string',
        'email_company' => 'string',
        'remarks' => 'string',
        'is_active' => 'boolean',
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
        'salary' => 'required',
        'application_condition' => 'required',
        'email_receive_applicant' => 'required|email',
        'categoryLevel3s' => 'required|array|exists:category_level3s,id',
        'prefectures' => 'required|array|exists:prefectures,id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function salaries()
    {
        return $this->belongsToMany(Salary::class);
    }

    public function prefectures()
    {
        return $this->belongsToMany(Prefecture::class);
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

    public function counters()
    {
        return $this->hasMany(JobCounter::class);
    }
    
    public function specialPromotions()
    {
        return $this->belongsToMany(SpecialPromotion::class, 'job_special');
    }
}

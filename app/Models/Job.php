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
        'company_name',
        'description',
        'post_start_date',
        'post_end_date',
        'salary',
        'education',
        'language',
        'language_level',
        'max_applicant',
        'application_condition',
        'message',
        'main_image',
        'main_caption',
        'email_receive_applicant',
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
        'education' => 'string',
        'language' => 'string',
        'language_level' => 'string',
        'max_applicant' => 'string',
        'salary' => 'string',
        'application_condition' => 'string',
        'message' => 'string',
        'main_image' => 'string',
        'main_caption' => 'string',
        'email_receive_applicant' => 'string',
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

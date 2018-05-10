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
        'user_id',
        'final_academic_school',
        'graduated_at',
        'education_id',
        'toeic',
        'toefl',
        'language_experience_id',
        'language_conversation_level_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'education_id' => 'integer',
        'final_academic_school' => 'stringo',
        'graduated_at' => 'datetime',
        'toeic' => 'integer',
        'toefl' => 'integer',
        'language_experience_id' => 'integer',
        'language_conversation_level_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'exists:users,id',
        'graduated_at' => 'nullable|date_format:Y-m-d',
        'toeic' => 'nullable|numeric|min:0',
        'toefl' => 'nullable|numeric|min:0',
        'language_experience_id' => 'exists:language_experiences,id',
        'language_conversation_level_id' => 'nullable|exists:language_conversation_levels,id',
        'education_id' => 'required',
        'working_days.*' => 'exists:working_days,id',
        'working_periods.*' => 'exists:working_periods,id',
        'working_hours.*' => 'exists:working_hours,id',
        'certificates.*' => 'exists:certificates,id',
        'certificate_groups.*' => 'exists:certificate_groups,id',
        'prefectures' => 'required|array|exists:prefectures,id',
        'salaries.*' => 'exists:salaries,id',
        'workingDays.*' => 'exists:working_days,id',
        'workingPeriods.*' => 'exists:working_periods,id',
        'workingHours.*' => 'exists:working_hours,id',
        'user.email' => 'sometimes|required|email',
        'user.gender' => 'sometimes|required|in:male,female',
        'user.birthday' => 'sometimes|required|date',
        'user.mail_receivable' => 'sometimes|required|boolean',
        'user.name' => 'sometimes|required',
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

    public function scopeMailable($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('mail_receivable', '=', 1);
        });
    }
}

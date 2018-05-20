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
        'education',
        'language',
        'language_level',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'education' => 'string',
        'final_academic_school' => 'string',
        'graduated_at' => 'datetime',
        'language' => 'string',
        'language_level' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'exists:users,id',
        'graduated_at' => 'nullable|date_format:Y-m-d',
        'education' => 'required',
        'prefectures' => 'required|array|exists:prefectures,id',
        'certificates.*' => 'exists:certificates,id',
        'certificate_groups.*' => 'exists:certificate_groups,id',
        'user.email' => 'sometimes|required|email',
        'user.gender' => 'sometimes|required|in:male,female',
        'user.birthday' => 'sometimes|required|date',
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

    public function prefectures()
    {
        return $this->belongsToMany(Prefecture::class);
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }
}

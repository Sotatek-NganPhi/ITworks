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
        'address',
        'phone_number',
        'gender',
        'birthday',
        'education_id',
        'final_academic_school',
        'graduated_at',
        'toeic',
        'toefl',
        'language_experience_id',
        'language_conversation_level_id',
        'status',
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
        'address' => 'string',
        'phone_number' => 'string',
        'gender' => 'string',
        'birthday' => 'date',
        'education_id' => 'integer',
        'final_academic_school' => 'string',
        'graduated_at' => 'date',
        'toeic' => 'float',
        'toefl' => 'float',
        'language_experience_id' => 'integer',
        'language_conversation_level_id' => 'integer',
        'status' => 'integer',
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

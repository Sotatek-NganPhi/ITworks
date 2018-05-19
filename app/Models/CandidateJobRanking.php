<?php

namespace App\Models;

use Eloquent as Model;

class CandidateJobRanking extends Model
{

    public $table = 'candidate_job_rankings';

    public $fillable = [
        'job_id',
        'candidate_id',
        'ranking',
    ];

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }
}

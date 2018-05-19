<?php

namespace App\Models;

use Eloquent as Model;
/**
 * Class JobCounter
 * @package App\Models
 * @version June 26, 2017, 1:04 am UTC
 */
class JobCounter extends Model
{
    public $table = 'job_counters';

    public $fillable = [
        'job_id',
        'view_date',
        'views',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'job_id' => 'integer',
        'view_date' => 'date',
        'views' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}

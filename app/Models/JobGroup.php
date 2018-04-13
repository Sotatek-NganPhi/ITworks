<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class JobGroup
 * @package App\Models
 * @version June 13, 2017, 4:11 pm UTC
 */
class JobGroup extends Model
{
    public $table = 'job_groups';

    public $fillable = [
        'parent_id',
        'level',
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'parent_id' => 'integer',
        'level' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
}

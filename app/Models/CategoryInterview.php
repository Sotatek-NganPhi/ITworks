<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;

/**
 * Class categoryInterview
 * @package App\Models
 * @version Sep 05, 2017
 */
class CategoryInterview extends Model
{

    public $table = 'category_interviews';

    public $fillable = [
        'id',
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'title'   => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'string',
    ];
}

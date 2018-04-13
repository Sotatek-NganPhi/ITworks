<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;

/**
 * Class Interview
 * @package App\Models
 * @version September 5, 2017, 12:32 pm UTC
 */
class Interview extends Model
{

    public $table = 'interviews';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'title',
        'picture',
        'thumbnail',
        'content',
        'sub_content',
        'date',
        'post_start_date',
        'post_end_date',
        'interviewer',
        'company_name',
        'company_description',
        'company_url',
        'category_interview_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'picture' => 'string',
        'thumbnail' => 'string',
        'content' => 'string',
        'sub_content' => 'string',
        'date' => 'date',
        'post_start_date' => 'date',
        'post_end_date' => 'date',
        'interviewer' => 'string',
        'company_name' => 'string',
        'company_description' => 'string',
        'company_url' => 'string',
        'category_interview_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'string|max:191',
        'picture' => 'string',
        'thumbnail' => 'string',
        'content' => 'string',
        'sub_content' => 'string',
        'date' => 'date',
        'post_start_date' => 'date',
        'post_end_date' => 'date||after:post_start_date',
        'interviewer' => 'string',
        'company_name' => 'string',
        'company_description' => 'string',
        'company_url' => 'url',
        'category_interview_id' => 'integer|exists:category_interviews,id',
        'regions' => 'array|exists:regions,id'
    ];

    public function categoryInterview()
    {
        return $this->hasOne('App\Models\CategoryInterview', 'id', 'category_interview_id');
    }

    public function getDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->toDateString();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value;
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'interview_region', 'interview_id', 'region_id');
    }
}

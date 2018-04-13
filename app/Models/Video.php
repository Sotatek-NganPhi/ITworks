<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Video
 * @package App\Models
 * @version September 6, 2017, 7:20 am UTC
 */
class Video extends Model
{

    public $table = 'videos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'description',
        'url',
        'thumbnail',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'url' => 'string',
        'thumbnail' => 'string',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:50',
        'description' => 'string|max:500',
        'url' => 'string|youtubeUrl',
        'thumbnail' => 'string',
        'is_active' => 'boolean'
    ];


    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }
}

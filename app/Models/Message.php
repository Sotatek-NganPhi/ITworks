<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    public $table = 'messages';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'applicant_id',
        'content',
        'title',
        'type',
        'metadata',
        'from',
        'user_id',
        'manager_id',
        'is_read',
        'is_favorite'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'applicant_id' => 'integer',
        'content' => 'string',
        'title' => 'string',
        'type' => 'boolean',
        'metadata' => 'string',
        'from' => 'string',
        'user_id' => 'integer',
        'manager_id' => 'integer',
        'is_read' => 'boolean',
        'is_favorite' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

}

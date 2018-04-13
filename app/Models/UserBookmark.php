<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBookmark extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
    ];
}

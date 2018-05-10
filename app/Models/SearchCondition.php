<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchCondition extends Model
{
    public $fillable = [
        'category_id',
        'prefecture_id',
        'free_word',
        'key_region',
        'user_id',
    ];
}

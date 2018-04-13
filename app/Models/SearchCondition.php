<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchCondition extends Model
{
    public $fillable = [
        'employment_mode_id',
        'category_id',
        'prefecture_id',
        'ward_id',
        'route_id',
        'station_id',
        'free_word',
        'key_region',
        'user_id',
        'merits'
    ];
}

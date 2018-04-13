<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class Ward
 * @package App\Models
 * @version June 13, 2017, 4:46 pm UTC
 */
class Ward extends VersionedModel
{

    public $table = 'wards';
    public static $tablename = 'wards';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'prefecture_id',
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'prefecture_id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}

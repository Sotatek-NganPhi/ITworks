<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CandidateCertificate
 * @package App\Models
 * @version 
 */

class CandidateCertificate extends VersionedModel
{
    public $table = 'candidate_certificate';
    public static $tablename = 'candidate_certificate';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'certificate_id',
        'candidate_id',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
}

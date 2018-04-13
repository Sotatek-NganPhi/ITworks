<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class CertigicateGroup
 * @package App\Models
 * @version 
 */

class CertificateGroup extends VersionedModel
{
    public $table = 'certificate_groups';
    public static $tablename = 'certificate_groups';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'name'
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

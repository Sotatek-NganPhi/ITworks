<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class LanguageConversationLevel
 * @package App\Models
 * @version June 25, 2017, 12:34 pm UTC
 */
class LanguageConversationLevel extends VersionedModel
{

    public $table = 'language_conversation_levels';
    public static $tablename = 'language_conversation_levels';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

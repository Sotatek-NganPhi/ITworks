<?php

namespace App\Models;

use Eloquent as Model;

class MailLogs extends Model
{
    public $table = 'mail_logs';
    public static $tablename = 'mail_logs';
    public static function getTableName() { return self::$tablename; }

    public $fillable = [
        'sender',
        'recipient',
        'subject',
        'type',
        'content',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'text'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

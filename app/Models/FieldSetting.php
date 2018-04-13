<?php

namespace App\Models;

use App\Models\Foundation\VersionedModel as VersionedModel;

/**
 * Class FieldSetting
 * @package App\Models
 * @version June 22, 2017, 7:48 am UTC
 */
class FieldSetting extends VersionedModel
{

    public $table = 'field_settings';
    public static function getTableName() { return 'field_settings'; }

    public $fillable = [
        'table_name',
        'field_name',
        'type',
        'display_name',
        'description',
        'emoji',
        'is_required',
        'input_method',
        'is_list_display',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'table_name' => 'string',
        'field_name' => 'string',
        'type' => 'integer',
        'display_name' => 'string',
        'description' => 'string',
        'emoji' => 'integer',
        'is_required' => 'integer',
        'input_method' => 'integer',
        'is_list_display' => 'integer',
        'is_active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public static function getGroupedData()
    {
        $result = [];
        $data = FieldSetting::getAll();
        foreach ($data as $record) {
            $tableName = $record->table_name;
            $fieldName = $record->field_name;
            if (!isset($data[$tableName])) {
                $data[$tableName] = [];
            }

            if (empty($record->display_name)) {
                $record->display_name = $record->field_name;
            }

            $result[$tableName][$fieldName] = $record;
        }

        return $result;
    }
}

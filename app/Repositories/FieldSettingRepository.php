<?php

namespace App\Repositories;

use App\Models\FieldSetting;
use InfyOm\Generator\Common\BaseRepository;

class FieldSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return FieldSetting::class;
    }

    public function rules()
    {
        return FieldSetting::$rules;
    }
}

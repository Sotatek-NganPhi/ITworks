<?php

use Faker\Factory as Faker;
use App\Models\FieldSetting;
use App\Repositories\FieldSettingRepository;

trait MakeFieldSettingTrait
{
    /**
     * Create fake instance of FieldSetting and save it in database
     *
     * @param array $fieldSettingFields
     * @return FieldSetting
     */
    public function makeFieldSetting($fieldSettingFields = [])
    {
        /** @var FieldSettingRepository $fieldSettingRepo */
        $fieldSettingRepo = App::make(FieldSettingRepository::class);
        $theme = $this->fakeFieldSettingData($fieldSettingFields);
        return $fieldSettingRepo->create($theme);
    }

    /**
     * Get fake instance of FieldSetting
     *
     * @param array $fieldSettingFields
     * @return FieldSetting
     */
    public function fakeFieldSetting($fieldSettingFields = [])
    {
        return new FieldSetting($this->fakeFieldSettingData($fieldSettingFields));
    }

    /**
     * Get fake data of FieldSetting
     *
     * @param array $postFields
     * @return array
     */
    public function fakeFieldSettingData($fieldSettingFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'table_name' => $fake->word,
            'field_name' => $fake->word,
            'type' => $fake->randomDigitNotNull,
            'display_name' => $fake->word,
            'description' => $fake->word,
            'emoji' => $fake->randomDigitNotNull,
            'is_required' => $fake->word,
            'input_method' => $fake->randomDigitNotNull,
            'is_list_display' => $fake->word,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $fieldSettingFields);
    }
}

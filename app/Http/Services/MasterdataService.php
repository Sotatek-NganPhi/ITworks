<?php

namespace App\Http\Services;

use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class MasterdataService
{
    protected static $tables = [
        'regions',
        'prefectures',
        'wards',
        'stations',
        'railway_lines',
        'line_stations',
        'salaries',
        'employment_modes',
        'working_shifts',
        'working_days',
        'working_hours',
        'working_periods',
        'certificate_groups',
        'certificates',
        'current_situations',
        'merits',
        'merit_groups',
        'category_level1s',
        'category_level2s',
        'category_level3s',
        'jumping_conditions',
        'jumping_dates',
        'educations',
        'industries',
        'company_sizes',
        'positions',
        'language_experiences',
        'language_conversation_levels',
        'driver_licenses',
        'configs',
        'field_settings',
        'references',
        'ref_enums',
        'ref_enum_values',
        'ref_tables',
        'companies',
        'certificate_groups',
        'certificates',
        'referral_agencies',
    ];

    protected static $localData = null;

    public static function getDataVersion()
    {
        if (Cache::has('dataVersion')) {
            return Cache::get('dataVersion');
        }

        self::getAllData();
        return Cache::get('dataVersion');
    }

    public static function getAllData()
    {
        if (self::$localData != null) {
            return self::$localData;
        }

        if (Cache::has('masterdata') && Cache::has('dataVersion')) {
            if (self::$localData == null) {
                self::$localData = Cache::get('masterdata');
            }

            return self::$localData;
        }

        $data = [];
        foreach (self::$tables as $table) {
            $data[$table] = DB::table($table)->get();
        }

        Cache::forever('masterdata', $data);
        $dataVersion =  sha1(json_encode($data));
        Config::where('key', 'dataVersion')->update(['value' => $dataVersion]);
        Cache::forever('dataVersion', $dataVersion);
        return $data;
    }

    public static function getOneTable($table)
    {
        $key = 'masterdata_'.$table;
        if (Cache::has($key)) {
            return collect(Cache::get($key));
        }

        $data = [];
        $allData = self::getAllData();
        if (!empty($allData[$table])) {
            $data = $allData[$table];
            Cache::forever($key, $data);
        }

        return collect($data);
    }

}

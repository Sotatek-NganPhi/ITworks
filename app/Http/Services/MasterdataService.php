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
        'salaries',
        'working_days',
        'working_hours',
        'certificate_groups',
        'certificates',
        'educations',
        'language_experiences',
        'language_conversation_levels',
        'configs',
        'field_settings',
        'companies',
        'certificate_groups',
        'certificates',
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

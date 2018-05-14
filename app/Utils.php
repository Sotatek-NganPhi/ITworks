<?php

namespace App;

use League\Csv\Writer;
use SplTempFileObject;
use ZipArchive;
use Exception;

class Utils
{
    public static function downloadCSV($headers, $data, $nameCsv)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne(Utils::utf8ToSjis($headers));
        $csv->insertall($data);

        $csv->output($nameCsv . ".csv");
    }

    //return the list of file names inside zip file
    public static function unzip($zipFilePath, $outputPath)
    {
        $zip = new ZipArchive;
        $fileNames = [];
        if ($zip->open($zipFilePath)) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = $zip->getNameIndex($i);
                if (Utils::startsWith($fileName, '__MACOSX/')) {
                    continue;
                }
                if (substr($fileName, -1) == DIRECTORY_SEPARATOR) {
                    throw new Exception("Zip file must not contain any directory. The following directory is found: " . $fileName, 1);
                }
                $fileNames[] = $fileName;
            }
            $zip->extractTo($outputPath);
            $zip->close();
        } else {
            throw new Exception("Zip file could not be opened");
        }
        return $fileNames;
    }

    public static function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public static function utf8ToSjis($fields)
    {
        if(is_array($fields)) {
            $row = [];
            foreach ($fields as $str) {
                $row[] =  mb_convert_encoding($str, 'SJIS', 'UTF-8');
            }
            return $row;
        }
        return mb_convert_encoding($fields, 'SJIS', 'UTF-8');
    }

    public static function toUtf8($str)
    {
        $encoding = mb_detect_encoding($str, "UTF-8, SJIS, JIS, eucjp-win, sjis-win");
        return mb_convert_encoding($str, 'UTF-8', $encoding);
    }

    public static function buildContentFileExcel($rows, $headers)
    {
        $data = [];
        foreach ($rows as $item){
           $row = collect($item)->toArray();
           foreach ($headers as $header){
               $row[$header] = Utils::utf8ToSjis($row[$header]);
           }
           $data[] = $row;
        }
        return $data;
    }

    public static function getReferralSource()
    {
        $data = [
            'from_search' => [
                'key' => 'from_search',
                'value' => 'Google'
            ],
            'from_facebook' => [
                'key' => 'from_facebook',
                'value' => 'Facebook'
            ],
        ];
        return $data;
    }

    public static function v4()
    {
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

<?php

namespace App\Http\Requests\API;

use App\Http\Services\MasterdataService;
use Illuminate\Foundation\Http\FormRequest;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use App\Models\FieldSetting;

class BaseRequest extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return Response::json(ResponseUtil::makeError($errors), 400);
    }

    public function appendRequired($tableName, $rulesOfTable)
    {
        $linkField = MasterdataService::getOneTable('field_settings')->where('table_name', $tableName);
        $rules = collect($rulesOfTable)->map(function($value, $key) use ($linkField) {
            $ruleItem = ($this->isRequired($linkField, $key)) ? "required|{$value}" : "nullable|{$value}";
            return $ruleItem;
        })->all();

        return $rules;
    }

    private function isRequired($collectfield, $field)
    {
        return $collectfield->where('field_name', $field)->pluck('is_required')->first();
    }

}

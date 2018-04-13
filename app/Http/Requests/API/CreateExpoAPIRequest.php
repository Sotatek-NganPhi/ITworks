<?php

namespace App\Http\Requests\API;

use App\Models\Expo;
use App\Http\Requests\API\BaseRequest;

class CreateExpoAPIRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Expo::$rules;
        $tableName = 'expos';
        $rules = $this->appendRequired($tableName, $rules);
        return $rules;
    }
}

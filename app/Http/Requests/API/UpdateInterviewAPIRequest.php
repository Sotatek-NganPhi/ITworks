<?php

namespace App\Http\Requests\API;

use App\Models\Interview;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Support\Facades\Log;

class UpdateInterviewAPIRequest extends BaseRequest
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
        $rules = Interview::$rules;
        $tableName = 'interviews';
        $rules = $this->appendRequired($tableName, $rules);
        return $rules;
    }
}

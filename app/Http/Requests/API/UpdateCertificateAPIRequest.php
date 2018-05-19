<?php

namespace App\Http\Requests\API;

use App\Models\Certificate;
use App\Http\Requests\API\BaseRequest;

class UpdateCertificateAPIRequest extends BaseRequest
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
        return Certificate::$rules;
    }
}

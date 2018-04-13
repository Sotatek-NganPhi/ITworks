<?php

namespace App\Http\Requests\API;

use App\Models\Company;
use App\Http\Requests\API\BaseRequest;

class UpdateCompanyAPIRequest extends BaseRequest
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
        $rules = $this->appendRequired('companies', Company::$rules);
        if ($this->oldUserName == $this->username) {
            $rules['username'] = 'required';
        }
        return $rules;
    }
}

<?php

namespace App\Http\Requests\API;

use App\Manager;
use App\User;
use App\Http\Requests\API\BaseRequest;

class CreateAdminAPIRequest extends BaseRequest
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
        $rules = $this->appendRequired('managers', Manager::$rules);
        $rules['password'] = 'required|confirmed';
        $rules['email'] .= '|unique:managers,email';
        return $rules;
    }
}

<?php

namespace App\Http\Requests\API;

use App\Models\Link;
use App\Http\Requests\API\BaseRequest;

class UpdateLinkAPIRequest extends BaseRequest
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
        $rules = Link::$rules;
        $tableName = 'links';
        $rules = $this->appendRequired($tableName, $rules);
        return $rules;
    }
}

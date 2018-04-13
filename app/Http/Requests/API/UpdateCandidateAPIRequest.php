<?php

namespace App\Http\Requests\API;

use App\Models\Candidate;
use App\Http\Requests\API\BaseRequest;

class UpdateCandidateAPIRequest extends BaseRequest
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
        return Candidate::$rules;
//        $rules = collect(Candidate::$rules)->mapWithKeys(function($value, $key) {
//            return [$key => $value.'|required'];
//        })->all();
//        return $rules;
    }
}

<?php

namespace App\Http\Requests\API;

use App\Models\SpecialPromotion;
use App\Http\Requests\API\BaseRequest;

class CreateSpecialPromotionAPIRequest extends BaseRequest
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
        $rules = SpecialPromotion::$rules;
        $table_name = 'special_promotions';
        return $this->appendRequired($table_name,$rules);
    }
}

<?php

namespace App\Http\Requests\API;

use App\Models\Pickup;
use App\Http\Requests\API\BaseRequest;

class CreatePickupAPIRequest extends BaseRequest
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
        $rules = Pickup::$rules;
        $table_name = 'pickups';
        $rules = $this->appendRequired($table_name,$rules);
        if($this->match_condition == 0){
            $rules['category_level3s'] = 'nullable';
            $rules['merits'] = 'nullable';
        }else if($this->match_condition == 1) {
            $rules['category_level3s'] = 'nullable';
        }else {
            $rules['merits'] = 'nullable';
        }
        return $rules;
    }
}

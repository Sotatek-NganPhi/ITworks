<?php

namespace App\Http\Requests\API;

use App\Models\Job;
use App\Http\Requests\API\BaseRequest;

class CreateJobAPIRequest extends BaseRequest
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
        return job::$rules;
    }
        public function attributes()
    {
        return [
            'company'                     => 'tên công ty',
            'post_start_date'             => 'ngày đăng tuyển',
            'post_end_date'               => 'ngày kết thúc đăng tuyển',
            'description'                 => 'mô tả',
            // 'company_name'                => '企業名',
            'salary'                      => 'lương',
            'application_condition'       => 'điều kiện ứng tuyển',
            'email_receive_applicant'     => 'email nhận đơn ứng tuyển ',          
        ];
    }
}

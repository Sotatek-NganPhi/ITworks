<?php

namespace App\Http\Requests\API;

use App\Models\Job;

class UpdatejobAPIRequest extends BaseRequest
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
            'salary'                      => 'lương',
            'company_name'                => 'tên công ty',
            'salary'                      => 'lương',
            'application_condition'       => 'điều kiện ứng tuyển',
            'email_receive_applicant'     => 'email nhận đơn ứng tuyển ',     
        ];
    }
}

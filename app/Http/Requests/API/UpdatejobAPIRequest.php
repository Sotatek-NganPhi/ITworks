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
            'company'                     => '掲載企業名',
            'post_start_date'             => '掲載開始日',
            'post_end_date'               => '掲載終了日',
            'description'                 => 'メインキャッチ',
            'company_name'                => '企業名',
            'salary'                      => '給与',
            'application_condition'       => '求める人材・経験・資格',
            'email_receive_applicant'     => '応募先メールアドレス ',
            'categoryLevel3s'            => '職種',
            'wards'                       => '市区町村',
     
        ];
    }
}

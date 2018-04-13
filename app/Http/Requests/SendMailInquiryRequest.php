<?php

namespace App\Http\Requests;

use App\Models\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SendMailInquiryRequest extends FormRequest
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
        return [
            'company_name' => 'required',
            'name_person' => 'required',
            'job_category' => 'required',
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$|^\d{3}-\d{2}$|^\d{3}$/'],
            'address' => 'required',
            'contact_phone_number' => ['required', 'regex:/^(?:\d{10}|\d{3}-\d{3}-\d{4}|\d{2}-\d{4}-\d{4}|\d{3}-\d{4}-\d{4})$/'],
            'contact_fax_number' => ['nullable', 'regex:/^(?:\d{10}|\d{3}-\d{3}-\d{4}|\d{2}-\d{4}-\d{4}|\d{3}-\d{4}-\d{4})$/'],
            'contact_email_address' => 'required|email',
            'content_inquiry' => 'required',
            'privacy_policy' => 'accepted',
            'desire' => 'required',
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        $inputs = $this->all();
        if (!isset($inputs['confirm'])) {
            return response()->view('app.inquiry', [
                'errors' => $errors,
                'inputs' => $inputs,
                'configs' => Config::getConfigByKey(),
                'submitted' => true
            ]);
        }
        return redirect()->route('inquiry');
    }

    public function attributes()
    {
        return [
            'company_name' => '企業名',
            'name_person' => 'ご担当者名',
            'job_category' => '職種',
            'postal_code' => '郵便番号',
            'address' => 'ご住所',
            'contact_phone_number' => 'ご連絡先電話番号',
            'contact_fax_number' => 'ご連絡先FAX番号',
            'contact_email_address' => 'ご連絡先メールアドレス',
            'content_inquiry' => 'お問い合わせ内容',
            'desire' => '当サイトをどこでお知りになりましたか？',
        ];
    }
}

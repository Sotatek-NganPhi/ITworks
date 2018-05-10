<?php

namespace App\Http\Requests;

use App\Models\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SendMailContactRequest extends FormRequest
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
            'name' => 'required',
            'mail_address' => 'required|email',
            'privacy_policy' => 'accepted',
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        $inputs = $this->all();
        if (!isset($inputs['confirm'])) {
            return response()->view('app.contact', [
                'errors' => $errors,
                'inputs' => $inputs,
                'configs' => Config::getConfigByKey(),
                'submitted' => true
            ]);
        }
        return redirect()->route('contact');
    }

    public function attributes()
    {
        return [
            'name' => 'ご担当者名',
            'mail_address' => 'メールアドレス',
        ];
    }
}

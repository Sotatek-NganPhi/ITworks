<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use InfyOm\Generator\Utils\ResponseUtil;

class MailRequest extends FormRequest
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
            "email"   => "required|email",
            "subject" => "required",
            "content" => "required"
        ];
    }

    public function attributes()
    {
        return [
            "email"   => "E-mail",
            "subject" => "Subject",
            "content" => "Content"
        ];
    }

    public function response(array $errors)
    {
        return Response::json(ResponseUtil::makeError($errors), 400);
    }
}

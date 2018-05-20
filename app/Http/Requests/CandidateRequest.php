<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CandidateRequest extends FormRequest
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
        $rules = collect(Candidate::$rules)->mapWithKeys(function($value, $key) {
            return [$key => "nullable|{$value}"];
        })->all();

        $rules['prefectures']             .= '|required';
        return $rules;
    }

    public function validate()
    {
        if ($this->input('submit') === 'Lưu bản nháp') {
            return true;
        }
        $this->prepareForValidation();

        $instance = $this->getValidatorInstance();

        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (!$instance->passes()) {
            $this->failedValidation($instance);
        }
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
        $inputs = $this->all();

        $this->session()->flash('errors', $errors);
        $this->merge($inputs);
        $this->flash();

        return response()->view('auth.candidate', [
            'errors'                     => $errors,
            'user'                       => Auth::user(),
            'regions'                    => Region::with('prefectures')->get(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Job;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Prefecture;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ApplyJobRequest extends FormRequest
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
            'first_name'                     => 'required|string|max:255',
            'last_name'                      => 'required|string|max:255',
            'address'                        => 'required|string|max:255',
            'phone_number'                   => 'required|string|max:255',
            'gender'                         => 'required|in:male,female',
            'birthday'                       => 'required|date',
            'education'                      => 'nullable|string|max:255',
            'graduated_at'                   => 'nullable|date',
            'language'         => 'nullable|string|max:255',
            'language_level' => 'nullable|string|max:255',
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        $inputs = $this->all();
        if (isset($inputs['back']) && $inputs['back'] === 'true') {
            return $this->goToPreviousPageApplyJob();
        }

        if (!isset($inputs['submitted'])) {
            return $this->goToPageApplyJob($errors, true);
        }
        return redirect()->route('resume_register');
    }

    public function attributes()
    {
        return [
            'first_name'                     => 'Họ',
            'last_name'                      => 'Tên',
            'gender'                         => 'Giới tính',
            'address'                        => 'Địa chỉ',
            'phone_number'                   => 'Số điện thoại',
            'birthday'                       => 'Ngày sinh',
            'graduated_at'                   => 'Thời gian tốt nghiệp',
            'final_academic_school'          => 'Học tại',
            'language'                       => 'Ngoại ngữ',
            'language_level'                 => 'Trình độ ngoại ngữ',
            'education'                      => 'Trình độ học vấn',
        ];
    }

    public function goToPreviousPageApplyJob()
    {
        $inputs = $this->all();
        $this->merge($inputs);
        $this->flash();

        return $this->goToPageApplyJob();
    }

    private function goToPageApplyJob($errors = [], $submitted = false)
    {
        $inputs = $this->all();
        return response()->view('app.job_application', [
            'job'                        => Job::find($inputs['job_id']),
            'errors'                     => $errors,
            'inputs'                     => $inputs,
            'submitted'                  => $submitted,
            'prefectures'                => Prefecture::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),

        ]);
    }
}

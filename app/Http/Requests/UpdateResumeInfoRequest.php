<?php

namespace App\Http\Requests;

use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Config;
use App\Models\Education;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UpdateResumeInfoRequest extends FormRequest
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
            'phone_number'                   => 'required',
            'gender'                         => 'required|in:male,female',
            'birthday'                       => 'required|date',
            'education_id'                   => 'required|exists:educations,id',
            'graduated_at'                   => 'nullable|date',
            'toeic'                          => 'nullable|numeric|min:0',
            'toefl'                          => 'nullable|numeric|min:0',
            'language_experience_id'         => 'nullable|exists:language_experiences,id',
            'language_conversation_level_id' => 'nullable|exists:language_conversation_levels,id',
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        $inputs = $this->all();
        if (isset($inputs['back']) && $inputs['back'] === 'true') {
            return $this->goToPreviousPageUpdateResumeInfo();
        }

        if (!isset($inputs['submitted'])) {
            return $this->goToPageCandidateResume($errors, true);
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
            'toeic'                          => 'TOEIC',
            'toefl'                          => 'TOEFL',
            'final_academic_school'          => 'Học tại',
            'language_experience_id'         => 'Kinh nghiệm',
            'language_conversation_level_id' => 'Kỹ năng giao tiếp',
            'education_id'                   => 'Trình độ học vấn',
        ];
    }

    public function goToPreviousPageUpdateResumeInfo()
    {
        $inputs = $this->all();
        $this->merge($inputs);
        $this->flash();

        return $this->goToPageCandidateResume();
    }

    private function goToPageCandidateResume($errors = [], $submitted = false)
    {
        return response()->view('app.member.candidate_resume', [
            'errors'                     => $errors,
            'inputs'                     => $this->all(),
            'submitted'                  => $submitted,
            'prefectures'                => Prefecture::getAll(),
            'educations'                 => Education::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
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
}

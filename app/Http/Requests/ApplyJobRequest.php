<?php

namespace App\Http\Requests;

use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Education;
use App\Models\Job;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Position;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Models\WorkingPeriod;
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
            'education_id'                   => 'required|exists:educations,id',
            'graduated_at'                   => 'nullable|date',
            'toeic'                          => 'nullable|numeric|min:0',
            'toefl'                          => 'nullable|numeric|min:0',
            'language_experience_id'         => 'nullable|exists:language_experiences,id',
            'language_conversation_level_id' => 'nullable|exists:language_conversation_levels,id',
            'status'                         => 'accepted',
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
            'toeic'                          => 'TOEIC',
            'toefl'                          => 'TOEFL',
            'final_academic_school'          => 'Học tại',
            'language_experience_id'         => 'Kinh nghiệm',
            'language_conversation_level_id' => '会話レベル',
            'education_id'                   => '最終学歴',
            'status'                         => '個人情報の取り扱い',
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
            'educations'                 => Education::getAll(),
            'positions'                  => Position::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'workingPeriods'             => WorkingPeriod::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
    }
}

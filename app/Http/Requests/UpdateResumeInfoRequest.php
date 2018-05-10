<?php

namespace App\Http\Requests;

use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\Config;
use App\Models\Education;
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
            'phone_number'                   => 'required|regex:/([0-9]{3}-[0-9]{4}-[0-9]{4})/u',
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
            'first_name'                     => '姓氏名',
            'last_name'                      => '名氏名',
            'gender'                         => '性別',
            'address'                        => '住所',
            'phone_number'                   => '電話番号',
            'birthday'                       => '生年月日',
            'graduated_at'                   => '卒業年度',
            'toeic'                          => 'TOEIC',
            'toefl'                          => 'TOEFL',
            'final_academic_school'          => '最終学歴　学校名',
            'language_experience_id'         => '実務経験',
            'language_conversation_level_id' => '会話レベル',
            'education_id'                   => '最終学歴',
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

    public function validate()
    {
        if ($this->input('submit') === '下書き保存') {
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

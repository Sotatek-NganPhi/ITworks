<?php

namespace App\Http\Requests;

use App\Models\CategoryLevel3;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\CompanySize;
use App\Models\CurrentSituation;
use App\Models\DriverLicense;
use App\Models\Education;
use App\Models\EmploymentMode;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JumpingCondition;
use App\Models\JumpingDate;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Position;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Models\WorkingPeriod;
use App\Models\WorkingShift;
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
            'first_name_phonetic'            => 'required|string|max:255',
            'last_name_phonetic'             => 'required|string|max:255',
            'postal_code'                    => 'required|string|regex:/^[0-9]{3}\-[0-9]{4}$/',
            'address'                        => 'required|string|max:255',
            'phone_number'                   => 'required|string|max:255',
            'gender'                         => 'required|in:male,female',
            'birthday'                       => 'required|date',
            'current_situation_id'           => 'required|exists:current_situations,id',
            'education_id'                   => 'required|exists:educations,id',
            'graduated_at'                   => 'nullable|date',
            'toeic'                          => 'nullable|numeric|min:0',
            'toefl'                          => 'nullable|numeric|min:0',
            'language_experience_id'         => 'nullable|exists:language_experiences,id',
            'language_conversation_level_id' => 'nullable|exists:language_conversation_levels,id',
            'driver_license_id'              => 'required|exists:driver_licenses,id',
            'worked_companies_number'        => 'required|numeric',
            'lastest_industry_id'            => 'required|exists:industries,id',
            'lastest_annual_income'          => 'required|numeric|min:0',
            'lastest_position_id'            => 'required|exists:positions,id',
            'status'                         => 'accepted',
            'resume_pr'                      => 'required',
            'lastest_company_name'           => 'required',
            'lastest_employment_mode_id'     => 'required|exists:employment_modes,id',
            'is_married'                     => 'boolean',
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
            'first_name'                     => '姓氏名',
            'last_name'                      => '名氏名',
            'first_name_phonetic'            => '姓フリガナ',
            'last_name_phonetic'             => '名フリガナ',
            'gender'                         => '性別',
            'postal_code'                    => '郵便番号',
            'address'                        => '住所',
            'phone_number'                   => '電話番号',
            'birthday'                       => '生年月日',
            'is_married'                     => '既婚未婚',
            'graduated_at'                   => '卒業年度',
            'toeic'                          => 'TOEIC',
            'toefl'                          => 'TOEFL',
            'final_academic_school'          => '最終学歴　学校名',
            'current_situation_id'           => '就業状況',
            'language_experience_id'         => '実務経験',
            'language_conversation_level_id' => '会話レベル',
            'driver_license_id'              => '自動車免許',
            'worked_companies_number'        => '経験社数',
            'lastest_industry_id'            => '現在または直前の勤務先の業種',
            'lastest_annual_income'          => '年収',
            'lastest_position_id'            => '役職',
            'education_id'                   => '最終学歴',
            'status'                         => '個人情報の取り扱い',
            'resume_pr'                      => 'PR',
            'lastest_company_name'           => '直近の職歴　会社名',
            'lastest_employment_mode_id'     => '雇用形態',
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
            'currentSituations'          => CurrentSituation::getAll(),
            'jumpingConditions'          => JumpingCondition::getAll(),
            'jumpingDates'               => JumpingDate::getAll(),
            'educations'                 => Education::getAll(),
            'employmentModes'            => EmploymentMode::getAll(),
            'industries'                 => Industry::getAll(),
            'companySizes'               => CompanySize::getAll(),
            'positions'                  => Position::getAll(),
            'regions'                    => Region::with('prefectures')->get(),
            'languageExperiences'        => LanguageExperience::getAll(),
            'languageConversationLevels' => LanguageConversationLevel::getAll(),
            'driverLicenses'             => DriverLicense::getAll(),
            'salaries'                   => Salary::getAll(),
            'workingShifts'              => WorkingShift::getAll(),
            'workingDays'                => WorkingDay::getAll(),
            'workingHours'               => WorkingHour::getAll(),
            'workingPeriods'             => WorkingPeriod::getAll(),
            'categoryLevel3s'            => CategoryLevel3::getAll(),
            'certificate_groups'         => CertificateGroup::getAll(),
            'certificates'               => Certificate::getAll(),
        ]);
    }
}

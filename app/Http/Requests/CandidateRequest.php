<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use App\Models\CategoryLevel3;
use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\CompanySize;
use App\Models\CurrentSituation;
use App\Models\DriverLicense;
use App\Models\Education;
use App\Models\EmploymentMode;
use App\Models\Industry;
use App\Models\JumpingCondition;
use App\Models\JumpingDate;
use App\Models\LanguageConversationLevel;
use App\Models\LanguageExperience;
use App\Models\Position;
use App\Models\Region;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Models\WorkingPeriod;
use App\Models\WorkingShift;
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

        $rules['current_situation_id']    .= '|required';
        $rules['jumping_date_id']         .= '|required';
        $rules['prefectures']             .= '|required';
        $rules['employment_modes']        .= '|required';
        $rules['mail_receivable']          = 'required';
        return $rules;
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

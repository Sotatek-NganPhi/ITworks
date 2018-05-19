<?php

use Faker\Factory as Faker;
use App\Models\Applicant;
use App\Repositories\ApplicantRepository;

trait MakeApplicantTrait
{
    /**
     * Create fake instance of Applicant and save it in database
     *
     * @param array $applicantFields
     * @return Applicant
     */
    public function makeApplicant($applicantFields = [])
    {
        /** @var ApplicantRepository $applicantRepo */
        $applicantRepo = App::make(ApplicantRepository::class);
        $theme = $this->fakeApplicantData($applicantFields);
        return $applicantRepo->create($theme);
    }

    /**
     * Get fake instance of Applicant
     *
     * @param array $applicantFields
     * @return Applicant
     */
    public function fakeApplicant($applicantFields = [])
    {
        return new Applicant($this->fakeApplicantData($applicantFields));
    }

    /**
     * Get fake data of Applicant
     *
     * @param array $postFields
     * @return array
     */
    public function fakeApplicantData($applicantFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'job_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'status' => $fake->randomDigitNotNull,
            'email' => $fake->word,
            'first_name' => $fake->word,
            'last_name' => $fake->word,
            'furigana_first_name' => $fake->word,
            'furigana_last_name' => $fake->word,
            'gender' => $fake->word,
            'phone_number' => $fake->word,
            'marital_status' => $fake->word,
            'birthday' => $fake->date('Y-m-d H:i:s'),
            'current_situations_id' => $fake->randomDigitNotNull,
            'prefectures_id' => $fake->randomDigitNotNull,
            'prefectures_code' => $fake->randomDigitNotNull,
            'address' => $fake->word,
            'recent_school_name' => $fake->word,
            'department' => $fake->word,
            'guarduation_year' => $fake->randomDigitNotNull,
            'academic_achievement' => $fake->text,
            'qualification' => $fake->word,
            'recent_employment' => $fake->word,
            'recent_employment_industry' => $fake->word,
            'recent_employment_job' => $fake->word,
            'recent_employment_period' => $fake->word,
            'pr' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $applicantFields);
    }
}

<?php

use Faker\Factory as Faker;
use App\Models\Candidate;
use App\Repositories\CandidateRepository;

trait MakeCandidateTrait
{
    /**
     * Create fake instance of Candidate and save it in database
     *
     * @param array $candidateFields
     * @return Candidate
     */
    public function makeCandidate($candidateFields = [])
    {
        /** @var CandidateRepository $candidateRepo */
        $candidateRepo = App::make(CandidateRepository::class);
        $theme = $this->fakeCandidateData($candidateFields);
        return $candidateRepo->create($theme);
    }

    /**
     * Get fake instance of Candidate
     *
     * @param array $candidateFields
     * @return Candidate
     */
    public function fakeCandidate($candidateFields = [])
    {
        return new Candidate($this->fakeCandidateData($candidateFields));
    }

    /**
     * Get fake data of Candidate
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCandidateData($candidateFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'is_married' => $fake->word,
            'current_situation_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'final_academic_school' => $fake->word,
            'graduated_at' => $fake->word,
            'toeic' => $fake->randomDigitNotNull,
            'toefl' => $fake->randomDigitNotNull,
            'language_experience_id' => $fake->randomDigitNotNull,
            'language_conversation_level_id' => $fake->randomDigitNotNull,
            'driver_license_id' => $fake->randomDigitNotNull,
            'jumping_condition_id' => $fake->randomDigitNotNull,
            'worked_companies_number' => $fake->randomDigitNotNull,
            'lastest_company_name' => $fake->word,
            'lastest_industry_id' => $fake->randomDigitNotNull,
            'lastest_company_size_id' => $fake->randomDigitNotNull,
            'lastest_annual_income' => $fake->randomDigitNotNull,
            'lastest_position_id' => $fake->randomDigitNotNull,
            'lastest_employment_mode_id' => $fake->randomDigitNotNull,
            'lastest_job_description' => $fake->text,
            'jumping_date_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $candidateFields);
    }
}

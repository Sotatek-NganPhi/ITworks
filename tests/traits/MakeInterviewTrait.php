<?php

use Faker\Factory as Faker;
use App\Models\Interview;
use App\Repositories\InterviewRepository;

trait MakeInterviewTrait
{
    /**
     * Create fake instance of Interview and save it in database
     *
     * @param array $interviewFields
     * @return Interview
     */
    public function makeInterview($interviewFields = [])
    {
        /** @var InterviewRepository $interviewRepo */
        $interviewRepo = App::make(InterviewRepository::class);
        $theme = $this->fakeInterviewData($interviewFields);
        return $interviewRepo->create($theme);
    }

    /**
     * Get fake instance of Interview
     *
     * @param array $interviewFields
     * @return Interview
     */
    public function fakeInterview($interviewFields = [])
    {
        return new Interview($this->fakeInterviewData($interviewFields));
    }

    /**
     * Get fake data of Interview
     *
     * @param array $postFields
     * @return array
     */
    public function fakeInterviewData($interviewFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'picture' => $fake->word,
            'thumbnail' => $fake->word,
            'content' => $fake->text,
            'sub_content' => $fake->word,
            'date' => $fake->word,
            'interviewer' => $fake->word,
            'company_id' => $fake->randomDigitNotNull,
            'category_interview_id' => $fake->randomDigitNotNull
        ], $interviewFields);
    }
}

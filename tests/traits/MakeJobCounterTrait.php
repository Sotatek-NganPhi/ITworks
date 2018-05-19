<?php

use Faker\Factory as Faker;
use App\Models\JobCounter;
use App\Repositories\JobCounterRepository;

trait MakeJobCounterTrait
{
    /**
     * Create fake instance of JobCounter and save it in database
     *
     * @param array $jobCounterFields
     * @return JobCounter
     */
    public function makeJobCounter($jobCounterFields = [])
    {
        /** @var JobCounterRepository $jobCounterRepo */
        $jobCounterRepo = App::make(JobCounterRepository::class);
        $theme = $this->fakeJobCounterData($jobCounterFields);
        return $jobCounterRepo->create($theme);
    }

    /**
     * Get fake instance of JobCounter
     *
     * @param array $jobCounterFields
     * @return JobCounter
     */
    public function fakeJobCounter($jobCounterFields = [])
    {
        return new JobCounter($this->fakeJobCounterData($jobCounterFields));
    }

    /**
     * Get fake data of JobCounter
     *
     * @param array $postFields
     * @return array
     */
    public function fakeJobCounterData($jobCounterFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'job_id' => $fake->randomDigitNotNull,
            'views' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $jobCounterFields);
    }
}

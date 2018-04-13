<?php

use Faker\Factory as Faker;
use App\Models\Job;
use App\Repositories\JobRepository;

trait MakejobTrait
{
    /**
     * Create fake instance of job and save it in database
     *
     * @param array $jobFields
     * @return job
     */
    public function makejob($jobFields = [])
    {
        /** @var JobRepository $jobRepo */
        $jobRepo = App::make(JobRepository::class);
        $theme = $this->fakejobData($jobFields);
        return $jobRepo->create($theme);
    }

    /**
     * Get fake instance of job
     *
     * @param array $jobFields
     * @return job
     */
    public function fakejob($jobFields = [])
    {
        return new job($this->fakejobData($jobFields));
    }

    /**
     * Get fake data of job
     *
     * @param array $postFields
     * @return array
     */
    public function fakejobData($jobFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'work_no' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $jobFields);
    }
}

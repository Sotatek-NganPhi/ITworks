<?php

use Faker\Factory as Faker;
use App\Models\JobGroup;
use App\Repositories\JobGroupRepository;

trait MakeJobGroupTrait
{
    /**
     * Create fake instance of JobGroup and save it in database
     *
     * @param array $jobGroupFields
     * @return JobGroup
     */
    public function makeJobGroup($jobGroupFields = [])
    {
        /** @var JobGroupRepository $jobGroupRepo */
        $jobGroupRepo = App::make(JobGroupRepository::class);
        $theme = $this->fakeJobGroupData($jobGroupFields);
        return $jobGroupRepo->create($theme);
    }

    /**
     * Get fake instance of JobGroup
     *
     * @param array $jobGroupFields
     * @return JobGroup
     */
    public function fakeJobGroup($jobGroupFields = [])
    {
        return new JobGroup($this->fakeJobGroupData($jobGroupFields));
    }

    /**
     * Get fake data of JobGroup
     *
     * @param array $postFields
     * @return array
     */
    public function fakeJobGroupData($jobGroupFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'parent_id' => $fake->randomDigitNotNull,
            'level' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $jobGroupFields);
    }
}

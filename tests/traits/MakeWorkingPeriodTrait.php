<?php

use Faker\Factory as Faker;
use App\Models\WorkingPeriod;
use App\Repositories\WorkingPeriodRepository;

trait MakeWorkingPeriodTrait
{
    /**
     * Create fake instance of WorkingPeriod and save it in database
     *
     * @param array $workingPeriodFields
     * @return WorkingPeriod
     */
    public function makeWorkingPeriod($workingPeriodFields = [])
    {
        /** @var WorkingPeriodRepository $workingPeriodRepo */
        $workingPeriodRepo = App::make(WorkingPeriodRepository::class);
        $theme = $this->fakeWorkingPeriodData($workingPeriodFields);
        return $workingPeriodRepo->create($theme);
    }

    /**
     * Get fake instance of WorkingPeriod
     *
     * @param array $workingPeriodFields
     * @return WorkingPeriod
     */
    public function fakeWorkingPeriod($workingPeriodFields = [])
    {
        return new WorkingPeriod($this->fakeWorkingPeriodData($workingPeriodFields));
    }

    /**
     * Get fake data of WorkingPeriod
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWorkingPeriodData($workingPeriodFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $workingPeriodFields);
    }
}

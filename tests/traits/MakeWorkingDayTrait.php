<?php

use Faker\Factory as Faker;
use App\Models\WorkingDay;
use App\Repositories\WorkingDayRepository;

trait MakeWorkingDayTrait
{
    /**
     * Create fake instance of WorkingDay and save it in database
     *
     * @param array $workingDayFields
     * @return WorkingDay
     */
    public function makeWorkingDay($workingDayFields = [])
    {
        /** @var WorkingDayRepository $workingDayRepo */
        $workingDayRepo = App::make(WorkingDayRepository::class);
        $theme = $this->fakeWorkingDayData($workingDayFields);
        return $workingDayRepo->create($theme);
    }

    /**
     * Get fake instance of WorkingDay
     *
     * @param array $workingDayFields
     * @return WorkingDay
     */
    public function fakeWorkingDay($workingDayFields = [])
    {
        return new WorkingDay($this->fakeWorkingDayData($workingDayFields));
    }

    /**
     * Get fake data of WorkingDay
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWorkingDayData($workingDayFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $workingDayFields);
    }
}

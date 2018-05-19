<?php

use Faker\Factory as Faker;
use App\Models\WorkingHour;
use App\Repositories\WorkingHourRepository;

trait MakeWorkingHourTrait
{
    /**
     * Create fake instance of WorkingHour and save it in database
     *
     * @param array $workingHourFields
     * @return WorkingHour
     */
    public function makeWorkingHour($workingHourFields = [])
    {
        /** @var WorkingHourRepository $workingHourRepo */
        $workingHourRepo = App::make(WorkingHourRepository::class);
        $theme = $this->fakeWorkingHourData($workingHourFields);
        return $workingHourRepo->create($theme);
    }

    /**
     * Get fake instance of WorkingHour
     *
     * @param array $workingHourFields
     * @return WorkingHour
     */
    public function fakeWorkingHour($workingHourFields = [])
    {
        return new WorkingHour($this->fakeWorkingHourData($workingHourFields));
    }

    /**
     * Get fake data of WorkingHour
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWorkingHourData($workingHourFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $workingHourFields);
    }
}

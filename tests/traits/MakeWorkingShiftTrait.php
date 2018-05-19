<?php

use Faker\Factory as Faker;
use App\Models\WorkingShift;
use App\Repositories\WorkingShiftRepository;

trait MakeWorkingShiftTrait
{
    /**
     * Create fake instance of WorkingShift and save it in database
     *
     * @param array $workingShiftFields
     * @return WorkingShift
     */
    public function makeWorkingShift($workingShiftFields = [])
    {
        /** @var WorkingShiftRepository $workingShiftRepo */
        $workingShiftRepo = App::make(WorkingShiftRepository::class);
        $theme = $this->fakeWorkingShiftData($workingShiftFields);
        return $workingShiftRepo->create($theme);
    }

    /**
     * Get fake instance of WorkingShift
     *
     * @param array $workingShiftFields
     * @return WorkingShift
     */
    public function fakeWorkingShift($workingShiftFields = [])
    {
        return new WorkingShift($this->fakeWorkingShiftData($workingShiftFields));
    }

    /**
     * Get fake data of WorkingShift
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWorkingShiftData($workingShiftFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $workingShiftFields);
    }
}

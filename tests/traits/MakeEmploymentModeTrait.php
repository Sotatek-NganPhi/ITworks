<?php

use Faker\Factory as Faker;
use App\Models\EmploymentMode;
use App\Repositories\EmploymentModeRepository;

trait MakeEmploymentModeTrait
{
    /**
     * Create fake instance of EmploymentMode and save it in database
     *
     * @param array $employmentModeFields
     * @return EmploymentMode
     */
    public function makeEmploymentMode($employmentModeFields = [])
    {
        /** @var EmploymentModeRepository $employmentModeRepo */
        $employmentModeRepo = App::make(EmploymentModeRepository::class);
        $theme = $this->fakeEmploymentModeData($employmentModeFields);
        return $employmentModeRepo->create($theme);
    }

    /**
     * Get fake instance of EmploymentMode
     *
     * @param array $employmentModeFields
     * @return EmploymentMode
     */
    public function fakeEmploymentMode($employmentModeFields = [])
    {
        return new EmploymentMode($this->fakeEmploymentModeData($employmentModeFields));
    }

    /**
     * Get fake data of EmploymentMode
     *
     * @param array $postFields
     * @return array
     */
    public function fakeEmploymentModeData($employmentModeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $employmentModeFields);
    }
}

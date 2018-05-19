<?php

use Faker\Factory as Faker;
use App\Models\JumpingDate;
use App\Repositories\JumpingDateRepository;

trait MakeJumpingDateTrait
{
    /**
     * Create fake instance of JumpingDate and save it in database
     *
     * @param array $jumpingDateFields
     * @return JumpingDate
     */
    public function makeJumpingDate($jumpingDateFields = [])
    {
        /** @var JumpingDateRepository $jumpingDateRepo */
        $jumpingDateRepo = App::make(JumpingDateRepository::class);
        $theme = $this->fakeJumpingDateData($jumpingDateFields);
        return $jumpingDateRepo->create($theme);
    }

    /**
     * Get fake instance of JumpingDate
     *
     * @param array $jumpingDateFields
     * @return JumpingDate
     */
    public function fakeJumpingDate($jumpingDateFields = [])
    {
        return new JumpingDate($this->fakeJumpingDateData($jumpingDateFields));
    }

    /**
     * Get fake data of JumpingDate
     *
     * @param array $postFields
     * @return array
     */
    public function fakeJumpingDateData($jumpingDateFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $jumpingDateFields);
    }
}

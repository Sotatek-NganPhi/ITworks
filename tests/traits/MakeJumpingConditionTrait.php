<?php

use Faker\Factory as Faker;
use App\Models\JumpingCondition;
use App\Repositories\JumpingConditionRepository;

trait MakeJumpingConditionTrait
{
    /**
     * Create fake instance of JumpingCondition and save it in database
     *
     * @param array $jumpingConditionFields
     * @return JumpingCondition
     */
    public function makeJumpingCondition($jumpingConditionFields = [])
    {
        /** @var JumpingConditionRepository $jumpingConditionRepo */
        $jumpingConditionRepo = App::make(JumpingConditionRepository::class);
        $theme = $this->fakeJumpingConditionData($jumpingConditionFields);
        return $jumpingConditionRepo->create($theme);
    }

    /**
     * Get fake instance of JumpingCondition
     *
     * @param array $jumpingConditionFields
     * @return JumpingCondition
     */
    public function fakeJumpingCondition($jumpingConditionFields = [])
    {
        return new JumpingCondition($this->fakeJumpingConditionData($jumpingConditionFields));
    }

    /**
     * Get fake data of JumpingCondition
     *
     * @param array $postFields
     * @return array
     */
    public function fakeJumpingConditionData($jumpingConditionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $jumpingConditionFields);
    }
}

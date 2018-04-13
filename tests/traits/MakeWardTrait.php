<?php

use Faker\Factory as Faker;
use App\Models\Ward;
use App\Repositories\WardRepository;

trait MakeWardTrait
{
    /**
     * Create fake instance of Ward and save it in database
     *
     * @param array $wardFields
     * @return Ward
     */
    public function makeWard($wardFields = [])
    {
        /** @var WardRepository $wardRepo */
        $wardRepo = App::make(WardRepository::class);
        $theme = $this->fakeWardData($wardFields);
        return $wardRepo->create($theme);
    }

    /**
     * Get fake instance of Ward
     *
     * @param array $wardFields
     * @return Ward
     */
    public function fakeWard($wardFields = [])
    {
        return new Ward($this->fakeWardData($wardFields));
    }

    /**
     * Get fake data of Ward
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWardData($wardFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'prefecture_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $wardFields);
    }
}

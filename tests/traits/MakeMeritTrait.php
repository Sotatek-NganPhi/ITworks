<?php

use Faker\Factory as Faker;
use App\Models\Merit;
use App\Repositories\MeritRepository;

trait MakeMeritTrait
{
    /**
     * Create fake instance of Merit and save it in database
     *
     * @param array $meritFields
     * @return Merit
     */
    public function makeMerit($meritFields = [])
    {
        /** @var MeritRepository $meritRepo */
        $meritRepo = App::make(MeritRepository::class);
        $theme = $this->fakeMeritData($meritFields);
        return $meritRepo->create($theme);
    }

    /**
     * Get fake instance of Merit
     *
     * @param array $meritFields
     * @return Merit
     */
    public function fakeMerit($meritFields = [])
    {
        return new Merit($this->fakeMeritData($meritFields));
    }

    /**
     * Get fake data of Merit
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMeritData($meritFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'display_order' => $fake->randomDigitNotNull,
            'merit_group_id' => $fake->randomDigitNotNull,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $meritFields);
    }
}

<?php

use Faker\Factory as Faker;
use App\Models\MeritGroup;
use App\Repositories\MeritGroupRepository;

trait MakeMeritGroupTrait
{
    /**
     * Create fake instance of MeritGroup and save it in database
     *
     * @param array $meritGroupFields
     * @return MeritGroup
     */
    public function makeMeritGroup($meritGroupFields = [])
    {
        /** @var MeritGroupRepository $meritGroupRepo */
        $meritGroupRepo = App::make(MeritGroupRepository::class);
        $theme = $this->fakeMeritGroupData($meritGroupFields);
        return $meritGroupRepo->create($theme);
    }

    /**
     * Get fake instance of MeritGroup
     *
     * @param array $meritGroupFields
     * @return MeritGroup
     */
    public function fakeMeritGroup($meritGroupFields = [])
    {
        return new MeritGroup($this->fakeMeritGroupData($meritGroupFields));
    }

    /**
     * Get fake data of MeritGroup
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMeritGroupData($meritGroupFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'display_order' => $fake->randomDigitNotNull,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $meritGroupFields);
    }
}

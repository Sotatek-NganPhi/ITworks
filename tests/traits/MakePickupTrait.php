<?php

use Faker\Factory as Faker;
use App\Models\Pickup;
use App\Repositories\PickupRepository;

trait MakePickupTrait
{
    /**
     * Create fake instance of Pickup and save it in database
     *
     * @param array $pickupFields
     * @return Pickup
     */
    public function makePickup($pickupFields = [])
    {
        /** @var PickupRepository $pickupRepo */
        $pickupRepo = App::make(PickupRepository::class);
        $theme = $this->fakePickupData($pickupFields);
        return $pickupRepo->create($theme);
    }

    /**
     * Get fake instance of Pickup
     *
     * @param array $pickupFields
     * @return Pickup
     */
    public function fakePickup($pickupFields = [])
    {
        return new Pickup($this->fakePickupData($pickupFields));
    }

    /**
     * Get fake data of Pickup
     *
     * @param array $postFields
     * @return array
     */
    public function fakePickupData($pickupFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type' => $fake->randomDigitNotNull,
            'match_condition' => $fake->randomDigitNotNull,
            'title' => $fake->word,
            'description' => $fake->word,
            'platform' => $fake->randomDigitNotNull,
            'image_pc' => $fake->word,
            'image_mobile' => $fake->word,
            'start_date' => $fake->date('Y-m-d H:i:s'),
            'end_date' => $fake->date('Y-m-d H:i:s'),
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $pickupFields);
    }
}

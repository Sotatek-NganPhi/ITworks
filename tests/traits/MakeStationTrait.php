<?php

use Faker\Factory as Faker;
use App\Models\Station;
use App\Repositories\StationRepository;

trait MakeStationTrait
{
    /**
     * Create fake instance of Station and save it in database
     *
     * @param array $stationFields
     * @return Station
     */
    public function makeStation($stationFields = [])
    {
        /** @var StationRepository $stationRepo */
        $stationRepo = App::make(StationRepository::class);
        $theme = $this->fakeStationData($stationFields);
        return $stationRepo->create($theme);
    }

    /**
     * Get fake instance of Station
     *
     * @param array $stationFields
     * @return Station
     */
    public function fakeStation($stationFields = [])
    {
        return new Station($this->fakeStationData($stationFields));
    }

    /**
     * Get fake data of Station
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStationData($stationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'ward_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $stationFields);
    }
}

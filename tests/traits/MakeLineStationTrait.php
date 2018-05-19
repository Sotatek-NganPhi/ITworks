<?php

use Faker\Factory as Faker;
use App\Models\LineStation;
use App\Repositories\LineStationRepository;

trait MakeLineStationTrait
{
    /**
     * Create fake instance of LineStation and save it in database
     *
     * @param array $lineStationFields
     * @return LineStation
     */
    public function makeLineStation($lineStationFields = [])
    {
        /** @var LineStationRepository $lineStationRepo */
        $lineStationRepo = App::make(LineStationRepository::class);
        $theme = $this->fakeLineStationData($lineStationFields);
        return $lineStationRepo->create($theme);
    }

    /**
     * Get fake instance of LineStation
     *
     * @param array $lineStationFields
     * @return LineStation
     */
    public function fakeLineStation($lineStationFields = [])
    {
        return new LineStation($this->fakeLineStationData($lineStationFields));
    }

    /**
     * Get fake data of LineStation
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLineStationData($lineStationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'line_id' => $fake->randomDigitNotNull,
            'station_id' => $fake->randomDigitNotNull,
            'order' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $lineStationFields);
    }
}

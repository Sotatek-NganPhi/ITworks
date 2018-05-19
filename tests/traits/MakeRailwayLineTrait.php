<?php

use Faker\Factory as Faker;
use App\Models\RailwayLine;
use App\Repositories\RailwayLineRepository;

trait MakeRailwayLineTrait
{
    /**
     * Create fake instance of RailwayLine and save it in database
     *
     * @param array $railwayLineFields
     * @return RailwayLine
     */
    public function makeRailwayLine($railwayLineFields = [])
    {
        /** @var RailwayLineRepository $railwayLineRepo */
        $railwayLineRepo = App::make(RailwayLineRepository::class);
        $theme = $this->fakeRailwayLineData($railwayLineFields);
        return $railwayLineRepo->create($theme);
    }

    /**
     * Get fake instance of RailwayLine
     *
     * @param array $railwayLineFields
     * @return RailwayLine
     */
    public function fakeRailwayLine($railwayLineFields = [])
    {
        return new RailwayLine($this->fakeRailwayLineData($railwayLineFields));
    }

    /**
     * Get fake data of RailwayLine
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRailwayLineData($railwayLineFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $railwayLineFields);
    }
}

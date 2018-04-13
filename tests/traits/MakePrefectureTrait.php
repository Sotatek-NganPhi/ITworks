<?php

use Faker\Factory as Faker;
use App\Models\Prefecture;
use App\Repositories\PrefectureRepository;

trait MakePrefectureTrait
{
    /**
     * Create fake instance of Prefecture and save it in database
     *
     * @param array $prefectureFields
     * @return Prefecture
     */
    public function makePrefecture($prefectureFields = [])
    {
        /** @var PrefectureRepository $prefectureRepo */
        $prefectureRepo = App::make(PrefectureRepository::class);
        $theme = $this->fakePrefectureData($prefectureFields);
        return $prefectureRepo->create($theme);
    }

    /**
     * Get fake instance of Prefecture
     *
     * @param array $prefectureFields
     * @return Prefecture
     */
    public function fakePrefecture($prefectureFields = [])
    {
        return new Prefecture($this->fakePrefectureData($prefectureFields));
    }

    /**
     * Get fake data of Prefecture
     *
     * @param array $postFields
     * @return array
     */
    public function fakePrefectureData($prefectureFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'region_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $prefectureFields);
    }
}

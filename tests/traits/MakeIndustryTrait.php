<?php

use Faker\Factory as Faker;
use App\Models\Industry;
use App\Repositories\IndustryRepository;

trait MakeIndustryTrait
{
    /**
     * Create fake instance of Industry and save it in database
     *
     * @param array $industryFields
     * @return Industry
     */
    public function makeIndustry($industryFields = [])
    {
        /** @var IndustryRepository $industryRepo */
        $industryRepo = App::make(IndustryRepository::class);
        $theme = $this->fakeIndustryData($industryFields);
        return $industryRepo->create($theme);
    }

    /**
     * Get fake instance of Industry
     *
     * @param array $industryFields
     * @return Industry
     */
    public function fakeIndustry($industryFields = [])
    {
        return new Industry($this->fakeIndustryData($industryFields));
    }

    /**
     * Get fake data of Industry
     *
     * @param array $postFields
     * @return array
     */
    public function fakeIndustryData($industryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $industryFields);
    }
}

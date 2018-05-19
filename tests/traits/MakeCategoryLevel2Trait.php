<?php

use Faker\Factory as Faker;
use App\Models\CategoryLevel2;
use App\Repositories\CategoryLevel2Repository;

trait MakeCategoryLevel2Trait
{
    /**
     * Create fake instance of CategoryLevel2 and save it in database
     *
     * @param array $categoryLevel2Fields
     * @return CategoryLevel2
     */
    public function makeCategoryLevel2($categoryLevel2Fields = [])
    {
        /** @var CategoryLevel2Repository $categoryLevel2Repo */
        $categoryLevel2Repo = App::make(CategoryLevel2Repository::class);
        $theme = $this->fakeCategoryLevel2Data($categoryLevel2Fields);
        return $categoryLevel2Repo->create($theme);
    }

    /**
     * Get fake instance of CategoryLevel2
     *
     * @param array $categoryLevel2Fields
     * @return CategoryLevel2
     */
    public function fakeCategoryLevel2($categoryLevel2Fields = [])
    {
        return new CategoryLevel2($this->fakeCategoryLevel2Data($categoryLevel2Fields));
    }

    /**
     * Get fake data of CategoryLevel2
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryLevel2Data($categoryLevel2Fields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'category_level1_id' => $fake->randomDigitNotNull,
            'display_order' => $fake->randomDigitNotNull,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryLevel2Fields);
    }
}

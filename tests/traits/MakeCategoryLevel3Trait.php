<?php

use Faker\Factory as Faker;
use App\Models\CategoryLevel3;
use App\Repositories\CategoryLevel3Repository;

trait MakeCategoryLevel3Trait
{
    /**
     * Create fake instance of CategoryLevel3 and save it in database
     *
     * @param array $categoryLevel3Fields
     * @return CategoryLevel3
     */
    public function makeCategoryLevel3($categoryLevel3Fields = [])
    {
        /** @var CategoryLevel3Repository $categoryLevel3Repo */
        $categoryLevel3Repo = App::make(CategoryLevel3Repository::class);
        $theme = $this->fakeCategoryLevel3Data($categoryLevel3Fields);
        return $categoryLevel3Repo->create($theme);
    }

    /**
     * Get fake instance of CategoryLevel3
     *
     * @param array $categoryLevel3Fields
     * @return CategoryLevel3
     */
    public function fakeCategoryLevel3($categoryLevel3Fields = [])
    {
        return new CategoryLevel3($this->fakeCategoryLevel3Data($categoryLevel3Fields));
    }

    /**
     * Get fake data of CategoryLevel3
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryLevel3Data($categoryLevel3Fields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'category_level2_id' => $fake->randomDigitNotNull,
            'display_order' => $fake->randomDigitNotNull,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryLevel3Fields);
    }
}

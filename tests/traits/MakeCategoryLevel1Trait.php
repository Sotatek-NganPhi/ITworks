<?php

use Faker\Factory as Faker;
use App\Models\CategoryLevel1;
use App\Repositories\CategoryLevel1Repository;

trait MakeCategoryLevel1Trait
{
    /**
     * Create fake instance of CategoryLevel1 and save it in database
     *
     * @param array $categoryLevel1Fields
     * @return CategoryLevel1
     */
    public function makeCategoryLevel1($categoryLevel1Fields = [])
    {
        /** @var CategoryLevel1Repository $categoryLevel1Repo */
        $categoryLevel1Repo = App::make(CategoryLevel1Repository::class);
        $theme = $this->fakeCategoryLevel1Data($categoryLevel1Fields);
        return $categoryLevel1Repo->create($theme);
    }

    /**
     * Get fake instance of CategoryLevel1
     *
     * @param array $categoryLevel1Fields
     * @return CategoryLevel1
     */
    public function fakeCategoryLevel1($categoryLevel1Fields = [])
    {
        return new CategoryLevel1($this->fakeCategoryLevel1Data($categoryLevel1Fields));
    }

    /**
     * Get fake data of CategoryLevel1
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCategoryLevel1Data($categoryLevel1Fields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'display_order' => $fake->randomDigitNotNull,
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $categoryLevel1Fields);
    }
}

<?php

use Faker\Factory as Faker;
use App\Models\LanguageExperience;
use App\Repositories\LanguageExperienceRepository;

trait MakeLanguageExperienceTrait
{
    /**
     * Create fake instance of LanguageExperience and save it in database
     *
     * @param array $languageExperienceFields
     * @return LanguageExperience
     */
    public function makeLanguageExperience($languageExperienceFields = [])
    {
        /** @var LanguageExperienceRepository $languageExperienceRepo */
        $languageExperienceRepo = App::make(LanguageExperienceRepository::class);
        $theme = $this->fakeLanguageExperienceData($languageExperienceFields);
        return $languageExperienceRepo->create($theme);
    }

    /**
     * Get fake instance of LanguageExperience
     *
     * @param array $languageExperienceFields
     * @return LanguageExperience
     */
    public function fakeLanguageExperience($languageExperienceFields = [])
    {
        return new LanguageExperience($this->fakeLanguageExperienceData($languageExperienceFields));
    }

    /**
     * Get fake data of LanguageExperience
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLanguageExperienceData($languageExperienceFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $languageExperienceFields);
    }
}

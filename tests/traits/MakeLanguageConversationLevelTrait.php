<?php

use Faker\Factory as Faker;
use App\Models\LanguageConversationLevel;
use App\Repositories\LanguageConversationLevelRepository;

trait MakeLanguageConversationLevelTrait
{
    /**
     * Create fake instance of LanguageConversationLevel and save it in database
     *
     * @param array $languageConversationLevelFields
     * @return LanguageConversationLevel
     */
    public function makeLanguageConversationLevel($languageConversationLevelFields = [])
    {
        /** @var LanguageConversationLevelRepository $languageConversationLevelRepo */
        $languageConversationLevelRepo = App::make(LanguageConversationLevelRepository::class);
        $theme = $this->fakeLanguageConversationLevelData($languageConversationLevelFields);
        return $languageConversationLevelRepo->create($theme);
    }

    /**
     * Get fake instance of LanguageConversationLevel
     *
     * @param array $languageConversationLevelFields
     * @return LanguageConversationLevel
     */
    public function fakeLanguageConversationLevel($languageConversationLevelFields = [])
    {
        return new LanguageConversationLevel($this->fakeLanguageConversationLevelData($languageConversationLevelFields));
    }

    /**
     * Get fake data of LanguageConversationLevel
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLanguageConversationLevelData($languageConversationLevelFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $languageConversationLevelFields);
    }
}

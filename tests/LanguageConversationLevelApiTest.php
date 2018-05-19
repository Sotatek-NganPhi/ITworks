<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageConversationLevelApiTest extends TestCase
{
    use MakeLanguageConversationLevelTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLanguageConversationLevel()
    {
        $languageConversationLevel = $this->fakeLanguageConversationLevelData();
        $this->json('POST', '/api/v1/languageConversationLevels', $languageConversationLevel);

        $this->assertApiResponse($languageConversationLevel);
    }

    /**
     * @test
     */
    public function testReadLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $this->json('GET', '/api/v1/languageConversationLevels/'.$languageConversationLevel->id);

        $this->assertApiResponse($languageConversationLevel->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $editedLanguageConversationLevel = $this->fakeLanguageConversationLevelData();

        $this->json('PUT', '/api/v1/languageConversationLevels/'.$languageConversationLevel->id, $editedLanguageConversationLevel);

        $this->assertApiResponse($editedLanguageConversationLevel);
    }

    /**
     * @test
     */
    public function testDeleteLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $this->json('DELETE', '/api/v1/languageConversationLevels/'.$languageConversationLevel->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/languageConversationLevels/'.$languageConversationLevel->id);

        $this->assertResponseStatus(404);
    }
}

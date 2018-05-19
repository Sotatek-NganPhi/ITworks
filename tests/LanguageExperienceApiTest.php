<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageExperienceApiTest extends TestCase
{
    use MakeLanguageExperienceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLanguageExperience()
    {
        $languageExperience = $this->fakeLanguageExperienceData();
        $this->json('POST', '/api/v1/languageExperiences', $languageExperience);

        $this->assertApiResponse($languageExperience);
    }

    /**
     * @test
     */
    public function testReadLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $this->json('GET', '/api/v1/languageExperiences/'.$languageExperience->id);

        $this->assertApiResponse($languageExperience->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $editedLanguageExperience = $this->fakeLanguageExperienceData();

        $this->json('PUT', '/api/v1/languageExperiences/'.$languageExperience->id, $editedLanguageExperience);

        $this->assertApiResponse($editedLanguageExperience);
    }

    /**
     * @test
     */
    public function testDeleteLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $this->json('DELETE', '/api/v1/languageExperiences/'.$languageExperience->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/languageExperiences/'.$languageExperience->id);

        $this->assertResponseStatus(404);
    }
}

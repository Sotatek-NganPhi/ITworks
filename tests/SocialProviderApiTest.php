<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocialProviderApiTest extends TestCase
{
    use MakeSocialProviderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSocialProvider()
    {
        $socialProvider = $this->fakeSocialProviderData();
        $this->json('POST', '/api/v1/socialProviders', $socialProvider);

        $this->assertApiResponse($socialProvider);
    }

    /**
     * @test
     */
    public function testReadSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $this->json('GET', '/api/v1/socialProviders/'.$socialProvider->id);

        $this->assertApiResponse($socialProvider->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $editedSocialProvider = $this->fakeSocialProviderData();

        $this->json('PUT', '/api/v1/socialProviders/'.$socialProvider->id, $editedSocialProvider);

        $this->assertApiResponse($editedSocialProvider);
    }

    /**
     * @test
     */
    public function testDeleteSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $this->json('DELETE', '/api/v1/socialProviders/'.$socialProvider->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/socialProviders/'.$socialProvider->id);

        $this->assertResponseStatus(404);
    }
}

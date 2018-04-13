<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecialPromotionApiTest extends TestCase
{
    use MakeSpecialPromotionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSpecialPromotion()
    {
        $specialPromotion = $this->fakeSpecialPromotionData();
        $this->json('POST', '/api/v1/specialPromotions', $specialPromotion);

        $this->assertApiResponse($specialPromotion);
    }

    /**
     * @test
     */
    public function testReadSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $this->json('GET', '/api/v1/specialPromotions/'.$specialPromotion->id);

        $this->assertApiResponse($specialPromotion->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $editedSpecialPromotion = $this->fakeSpecialPromotionData();

        $this->json('PUT', '/api/v1/specialPromotions/'.$specialPromotion->id, $editedSpecialPromotion);

        $this->assertApiResponse($editedSpecialPromotion);
    }

    /**
     * @test
     */
    public function testDeleteSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $this->json('DELETE', '/api/v1/specialPromotions/'.$specialPromotion->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/specialPromotions/'.$specialPromotion->id);

        $this->assertResponseStatus(404);
    }
}

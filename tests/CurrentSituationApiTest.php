<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CurrentSituationApiTest extends TestCase
{
    use MakeCurrentSituationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCurrentSituation()
    {
        $currentSituation = $this->fakeCurrentSituationData();
        $this->json('POST', '/api/v1/currentSituations', $currentSituation);

        $this->assertApiResponse($currentSituation);
    }

    /**
     * @test
     */
    public function testReadCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $this->json('GET', '/api/v1/currentSituations/'.$currentSituation->id);

        $this->assertApiResponse($currentSituation->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $editedCurrentSituation = $this->fakeCurrentSituationData();

        $this->json('PUT', '/api/v1/currentSituations/'.$currentSituation->id, $editedCurrentSituation);

        $this->assertApiResponse($editedCurrentSituation);
    }

    /**
     * @test
     */
    public function testDeleteCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $this->json('DELETE', '/api/v1/currentSituations/'.$currentSituation->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/currentSituations/'.$currentSituation->id);

        $this->assertResponseStatus(404);
    }
}

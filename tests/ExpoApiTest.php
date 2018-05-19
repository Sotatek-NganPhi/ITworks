<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpoApiTest extends TestCase
{
    use MakeExpoTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateExpo()
    {
        $expo = $this->fakeExpoData();
        $this->json('POST', '/api/v1/expos', $expo);

        $this->assertApiResponse($expo);
    }

    /**
     * @test
     */
    public function testReadExpo()
    {
        $expo = $this->makeExpo();
        $this->json('GET', '/api/v1/expos/'.$expo->id);

        $this->assertApiResponse($expo->toArray());
    }

    /**
     * @test
     */
    public function testUpdateExpo()
    {
        $expo = $this->makeExpo();
        $editedExpo = $this->fakeExpoData();

        $this->json('PUT', '/api/v1/expos/'.$expo->id, $editedExpo);

        $this->assertApiResponse($editedExpo);
    }

    /**
     * @test
     */
    public function testDeleteExpo()
    {
        $expo = $this->makeExpo();
        $this->json('DELETE', '/api/v1/expos/'.$expo->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/expos/'.$expo->id);

        $this->assertResponseStatus(404);
    }
}

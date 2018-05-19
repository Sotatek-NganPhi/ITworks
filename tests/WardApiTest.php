<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WardApiTest extends TestCase
{
    use MakeWardTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWard()
    {
        $ward = $this->fakeWardData();
        $this->json('POST', '/api/v1/wards', $ward);

        $this->assertApiResponse($ward);
    }

    /**
     * @test
     */
    public function testReadWard()
    {
        $ward = $this->makeWard();
        $this->json('GET', '/api/v1/wards/'.$ward->id);

        $this->assertApiResponse($ward->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWard()
    {
        $ward = $this->makeWard();
        $editedWard = $this->fakeWardData();

        $this->json('PUT', '/api/v1/wards/'.$ward->id, $editedWard);

        $this->assertApiResponse($editedWard);
    }

    /**
     * @test
     */
    public function testDeleteWard()
    {
        $ward = $this->makeWard();
        $this->json('DELETE', '/api/v1/wards/'.$ward->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/wards/'.$ward->id);

        $this->assertResponseStatus(404);
    }
}

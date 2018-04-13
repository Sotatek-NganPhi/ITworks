<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndustryApiTest extends TestCase
{
    use MakeIndustryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateIndustry()
    {
        $industry = $this->fakeIndustryData();
        $this->json('POST', '/api/v1/industries', $industry);

        $this->assertApiResponse($industry);
    }

    /**
     * @test
     */
    public function testReadIndustry()
    {
        $industry = $this->makeIndustry();
        $this->json('GET', '/api/v1/industries/'.$industry->id);

        $this->assertApiResponse($industry->toArray());
    }

    /**
     * @test
     */
    public function testUpdateIndustry()
    {
        $industry = $this->makeIndustry();
        $editedIndustry = $this->fakeIndustryData();

        $this->json('PUT', '/api/v1/industries/'.$industry->id, $editedIndustry);

        $this->assertApiResponse($editedIndustry);
    }

    /**
     * @test
     */
    public function testDeleteIndustry()
    {
        $industry = $this->makeIndustry();
        $this->json('DELETE', '/api/v1/industries/'.$industry->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/industries/'.$industry->id);

        $this->assertResponseStatus(404);
    }
}

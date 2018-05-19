<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeritApiTest extends TestCase
{
    use MakeMeritTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMerit()
    {
        $merit = $this->fakeMeritData();
        $this->json('POST', '/api/v1/merits', $merit);

        $this->assertApiResponse($merit);
    }

    /**
     * @test
     */
    public function testReadMerit()
    {
        $merit = $this->makeMerit();
        $this->json('GET', '/api/v1/merits/'.$merit->id);

        $this->assertApiResponse($merit->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMerit()
    {
        $merit = $this->makeMerit();
        $editedMerit = $this->fakeMeritData();

        $this->json('PUT', '/api/v1/merits/'.$merit->id, $editedMerit);

        $this->assertApiResponse($editedMerit);
    }

    /**
     * @test
     */
    public function testDeleteMerit()
    {
        $merit = $this->makeMerit();
        $this->json('DELETE', '/api/v1/merits/'.$merit->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/merits/'.$merit->id);

        $this->assertResponseStatus(404);
    }
}

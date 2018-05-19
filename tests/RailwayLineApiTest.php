<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RailwayLineApiTest extends TestCase
{
    use MakeRailwayLineTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRailwayLine()
    {
        $railwayLine = $this->fakeRailwayLineData();
        $this->json('POST', '/api/v1/railwayLines', $railwayLine);

        $this->assertApiResponse($railwayLine);
    }

    /**
     * @test
     */
    public function testReadRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $this->json('GET', '/api/v1/railwayLines/'.$railwayLine->id);

        $this->assertApiResponse($railwayLine->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $editedRailwayLine = $this->fakeRailwayLineData();

        $this->json('PUT', '/api/v1/railwayLines/'.$railwayLine->id, $editedRailwayLine);

        $this->assertApiResponse($editedRailwayLine);
    }

    /**
     * @test
     */
    public function testDeleteRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $this->json('DELETE', '/api/v1/railwayLines/'.$railwayLine->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/railwayLines/'.$railwayLine->id);

        $this->assertResponseStatus(404);
    }
}

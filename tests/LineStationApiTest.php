<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LineStationApiTest extends TestCase
{
    use MakeLineStationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLineStation()
    {
        $lineStation = $this->fakeLineStationData();
        $this->json('POST', '/api/v1/lineStations', $lineStation);

        $this->assertApiResponse($lineStation);
    }

    /**
     * @test
     */
    public function testReadLineStation()
    {
        $lineStation = $this->makeLineStation();
        $this->json('GET', '/api/v1/lineStations/'.$lineStation->id);

        $this->assertApiResponse($lineStation->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLineStation()
    {
        $lineStation = $this->makeLineStation();
        $editedLineStation = $this->fakeLineStationData();

        $this->json('PUT', '/api/v1/lineStations/'.$lineStation->id, $editedLineStation);

        $this->assertApiResponse($editedLineStation);
    }

    /**
     * @test
     */
    public function testDeleteLineStation()
    {
        $lineStation = $this->makeLineStation();
        $this->json('DELETE', '/api/v1/lineStations/'.$lineStation->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/lineStations/'.$lineStation->id);

        $this->assertResponseStatus(404);
    }
}

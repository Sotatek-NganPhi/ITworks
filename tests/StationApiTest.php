<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationApiTest extends TestCase
{
    use MakeStationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStation()
    {
        $station = $this->fakeStationData();
        $this->json('POST', '/api/v1/stations', $station);

        $this->assertApiResponse($station);
    }

    /**
     * @test
     */
    public function testReadStation()
    {
        $station = $this->makeStation();
        $this->json('GET', '/api/v1/stations/'.$station->id);

        $this->assertApiResponse($station->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStation()
    {
        $station = $this->makeStation();
        $editedStation = $this->fakeStationData();

        $this->json('PUT', '/api/v1/stations/'.$station->id, $editedStation);

        $this->assertApiResponse($editedStation);
    }

    /**
     * @test
     */
    public function testDeleteStation()
    {
        $station = $this->makeStation();
        $this->json('DELETE', '/api/v1/stations/'.$station->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/stations/'.$station->id);

        $this->assertResponseStatus(404);
    }
}

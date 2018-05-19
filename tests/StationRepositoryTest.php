<?php

use App\Models\Station;
use App\Repositories\StationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StationRepositoryTest extends TestCase
{
    use MakeStationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StationRepository
     */
    protected $stationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stationRepo = App::make(StationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStation()
    {
        $station = $this->fakeStationData();
        $createdStation = $this->stationRepo->create($station);
        $createdStation = $createdStation->toArray();
        $this->assertArrayHasKey('id', $createdStation);
        $this->assertNotNull($createdStation['id'], 'Created Station must have id specified');
        $this->assertNotNull(Station::find($createdStation['id']), 'Station with given id must be in DB');
        $this->assertModelData($station, $createdStation);
    }

    /**
     * @test read
     */
    public function testReadStation()
    {
        $station = $this->makeStation();
        $dbStation = $this->stationRepo->find($station->id);
        $dbStation = $dbStation->toArray();
        $this->assertModelData($station->toArray(), $dbStation);
    }

    /**
     * @test update
     */
    public function testUpdateStation()
    {
        $station = $this->makeStation();
        $fakeStation = $this->fakeStationData();
        $updatedStation = $this->stationRepo->update($fakeStation, $station->id);
        $this->assertModelData($fakeStation, $updatedStation->toArray());
        $dbStation = $this->stationRepo->find($station->id);
        $this->assertModelData($fakeStation, $dbStation->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStation()
    {
        $station = $this->makeStation();
        $resp = $this->stationRepo->delete($station->id);
        $this->assertTrue($resp);
        $this->assertNull(Station::find($station->id), 'Station should not exist in DB');
    }
}

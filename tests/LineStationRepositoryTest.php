<?php

use App\Models\LineStation;
use App\Repositories\LineStationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LineStationRepositoryTest extends TestCase
{
    use MakeLineStationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LineStationRepository
     */
    protected $lineStationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->lineStationRepo = App::make(LineStationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLineStation()
    {
        $lineStation = $this->fakeLineStationData();
        $createdLineStation = $this->lineStationRepo->create($lineStation);
        $createdLineStation = $createdLineStation->toArray();
        $this->assertArrayHasKey('id', $createdLineStation);
        $this->assertNotNull($createdLineStation['id'], 'Created LineStation must have id specified');
        $this->assertNotNull(LineStation::find($createdLineStation['id']), 'LineStation with given id must be in DB');
        $this->assertModelData($lineStation, $createdLineStation);
    }

    /**
     * @test read
     */
    public function testReadLineStation()
    {
        $lineStation = $this->makeLineStation();
        $dbLineStation = $this->lineStationRepo->find($lineStation->id);
        $dbLineStation = $dbLineStation->toArray();
        $this->assertModelData($lineStation->toArray(), $dbLineStation);
    }

    /**
     * @test update
     */
    public function testUpdateLineStation()
    {
        $lineStation = $this->makeLineStation();
        $fakeLineStation = $this->fakeLineStationData();
        $updatedLineStation = $this->lineStationRepo->update($fakeLineStation, $lineStation->id);
        $this->assertModelData($fakeLineStation, $updatedLineStation->toArray());
        $dbLineStation = $this->lineStationRepo->find($lineStation->id);
        $this->assertModelData($fakeLineStation, $dbLineStation->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLineStation()
    {
        $lineStation = $this->makeLineStation();
        $resp = $this->lineStationRepo->delete($lineStation->id);
        $this->assertTrue($resp);
        $this->assertNull(LineStation::find($lineStation->id), 'LineStation should not exist in DB');
    }
}

<?php

use App\Models\RailwayLine;
use App\Repositories\RailwayLineRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RailwayLineRepositoryTest extends TestCase
{
    use MakeRailwayLineTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RailwayLineRepository
     */
    protected $railwayLineRepo;

    public function setUp()
    {
        parent::setUp();
        $this->railwayLineRepo = App::make(RailwayLineRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRailwayLine()
    {
        $railwayLine = $this->fakeRailwayLineData();
        $createdRailwayLine = $this->railwayLineRepo->create($railwayLine);
        $createdRailwayLine = $createdRailwayLine->toArray();
        $this->assertArrayHasKey('id', $createdRailwayLine);
        $this->assertNotNull($createdRailwayLine['id'], 'Created RailwayLine must have id specified');
        $this->assertNotNull(RailwayLine::find($createdRailwayLine['id']), 'RailwayLine with given id must be in DB');
        $this->assertModelData($railwayLine, $createdRailwayLine);
    }

    /**
     * @test read
     */
    public function testReadRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $dbRailwayLine = $this->railwayLineRepo->find($railwayLine->id);
        $dbRailwayLine = $dbRailwayLine->toArray();
        $this->assertModelData($railwayLine->toArray(), $dbRailwayLine);
    }

    /**
     * @test update
     */
    public function testUpdateRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $fakeRailwayLine = $this->fakeRailwayLineData();
        $updatedRailwayLine = $this->railwayLineRepo->update($fakeRailwayLine, $railwayLine->id);
        $this->assertModelData($fakeRailwayLine, $updatedRailwayLine->toArray());
        $dbRailwayLine = $this->railwayLineRepo->find($railwayLine->id);
        $this->assertModelData($fakeRailwayLine, $dbRailwayLine->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRailwayLine()
    {
        $railwayLine = $this->makeRailwayLine();
        $resp = $this->railwayLineRepo->delete($railwayLine->id);
        $this->assertTrue($resp);
        $this->assertNull(RailwayLine::find($railwayLine->id), 'RailwayLine should not exist in DB');
    }
}

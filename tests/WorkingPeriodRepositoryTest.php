<?php

use App\Models\WorkingPeriod;
use App\Repositories\WorkingPeriodRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingPeriodRepositoryTest extends TestCase
{
    use MakeWorkingPeriodTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkingPeriodRepository
     */
    protected $workingPeriodRepo;

    public function setUp()
    {
        parent::setUp();
        $this->workingPeriodRepo = App::make(WorkingPeriodRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWorkingPeriod()
    {
        $workingPeriod = $this->fakeWorkingPeriodData();
        $createdWorkingPeriod = $this->workingPeriodRepo->create($workingPeriod);
        $createdWorkingPeriod = $createdWorkingPeriod->toArray();
        $this->assertArrayHasKey('id', $createdWorkingPeriod);
        $this->assertNotNull($createdWorkingPeriod['id'], 'Created WorkingPeriod must have id specified');
        $this->assertNotNull(WorkingPeriod::find($createdWorkingPeriod['id']), 'WorkingPeriod with given id must be in DB');
        $this->assertModelData($workingPeriod, $createdWorkingPeriod);
    }

    /**
     * @test read
     */
    public function testReadWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $dbWorkingPeriod = $this->workingPeriodRepo->find($workingPeriod->id);
        $dbWorkingPeriod = $dbWorkingPeriod->toArray();
        $this->assertModelData($workingPeriod->toArray(), $dbWorkingPeriod);
    }

    /**
     * @test update
     */
    public function testUpdateWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $fakeWorkingPeriod = $this->fakeWorkingPeriodData();
        $updatedWorkingPeriod = $this->workingPeriodRepo->update($fakeWorkingPeriod, $workingPeriod->id);
        $this->assertModelData($fakeWorkingPeriod, $updatedWorkingPeriod->toArray());
        $dbWorkingPeriod = $this->workingPeriodRepo->find($workingPeriod->id);
        $this->assertModelData($fakeWorkingPeriod, $dbWorkingPeriod->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $resp = $this->workingPeriodRepo->delete($workingPeriod->id);
        $this->assertTrue($resp);
        $this->assertNull(WorkingPeriod::find($workingPeriod->id), 'WorkingPeriod should not exist in DB');
    }
}

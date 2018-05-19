<?php

use App\Models\WorkingDay;
use App\Repositories\WorkingDayRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingDayRepositoryTest extends TestCase
{
    use MakeWorkingDayTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkingDayRepository
     */
    protected $workingDayRepo;

    public function setUp()
    {
        parent::setUp();
        $this->workingDayRepo = App::make(WorkingDayRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWorkingDay()
    {
        $workingDay = $this->fakeWorkingDayData();
        $createdWorkingDay = $this->workingDayRepo->create($workingDay);
        $createdWorkingDay = $createdWorkingDay->toArray();
        $this->assertArrayHasKey('id', $createdWorkingDay);
        $this->assertNotNull($createdWorkingDay['id'], 'Created WorkingDay must have id specified');
        $this->assertNotNull(WorkingDay::find($createdWorkingDay['id']), 'WorkingDay with given id must be in DB');
        $this->assertModelData($workingDay, $createdWorkingDay);
    }

    /**
     * @test read
     */
    public function testReadWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $dbWorkingDay = $this->workingDayRepo->find($workingDay->id);
        $dbWorkingDay = $dbWorkingDay->toArray();
        $this->assertModelData($workingDay->toArray(), $dbWorkingDay);
    }

    /**
     * @test update
     */
    public function testUpdateWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $fakeWorkingDay = $this->fakeWorkingDayData();
        $updatedWorkingDay = $this->workingDayRepo->update($fakeWorkingDay, $workingDay->id);
        $this->assertModelData($fakeWorkingDay, $updatedWorkingDay->toArray());
        $dbWorkingDay = $this->workingDayRepo->find($workingDay->id);
        $this->assertModelData($fakeWorkingDay, $dbWorkingDay->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $resp = $this->workingDayRepo->delete($workingDay->id);
        $this->assertTrue($resp);
        $this->assertNull(WorkingDay::find($workingDay->id), 'WorkingDay should not exist in DB');
    }
}

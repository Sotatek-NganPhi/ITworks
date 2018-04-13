<?php

use App\Models\WorkingShift;
use App\Repositories\WorkingShiftRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingShiftRepositoryTest extends TestCase
{
    use MakeWorkingShiftTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkingShiftRepository
     */
    protected $workingShiftRepo;

    public function setUp()
    {
        parent::setUp();
        $this->workingShiftRepo = App::make(WorkingShiftRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWorkingShift()
    {
        $workingShift = $this->fakeWorkingShiftData();
        $createdWorkingShift = $this->workingShiftRepo->create($workingShift);
        $createdWorkingShift = $createdWorkingShift->toArray();
        $this->assertArrayHasKey('id', $createdWorkingShift);
        $this->assertNotNull($createdWorkingShift['id'], 'Created WorkingShift must have id specified');
        $this->assertNotNull(WorkingShift::find($createdWorkingShift['id']), 'WorkingShift with given id must be in DB');
        $this->assertModelData($workingShift, $createdWorkingShift);
    }

    /**
     * @test read
     */
    public function testReadWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $dbWorkingShift = $this->workingShiftRepo->find($workingShift->id);
        $dbWorkingShift = $dbWorkingShift->toArray();
        $this->assertModelData($workingShift->toArray(), $dbWorkingShift);
    }

    /**
     * @test update
     */
    public function testUpdateWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $fakeWorkingShift = $this->fakeWorkingShiftData();
        $updatedWorkingShift = $this->workingShiftRepo->update($fakeWorkingShift, $workingShift->id);
        $this->assertModelData($fakeWorkingShift, $updatedWorkingShift->toArray());
        $dbWorkingShift = $this->workingShiftRepo->find($workingShift->id);
        $this->assertModelData($fakeWorkingShift, $dbWorkingShift->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $resp = $this->workingShiftRepo->delete($workingShift->id);
        $this->assertTrue($resp);
        $this->assertNull(WorkingShift::find($workingShift->id), 'WorkingShift should not exist in DB');
    }
}

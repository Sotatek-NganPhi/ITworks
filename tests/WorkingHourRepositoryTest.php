<?php

use App\Models\WorkingHour;
use App\Repositories\WorkingHourRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingHourRepositoryTest extends TestCase
{
    use MakeWorkingHourTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkingHourRepository
     */
    protected $workingHourRepo;

    public function setUp()
    {
        parent::setUp();
        $this->workingHourRepo = App::make(WorkingHourRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWorkingHour()
    {
        $workingHour = $this->fakeWorkingHourData();
        $createdWorkingHour = $this->workingHourRepo->create($workingHour);
        $createdWorkingHour = $createdWorkingHour->toArray();
        $this->assertArrayHasKey('id', $createdWorkingHour);
        $this->assertNotNull($createdWorkingHour['id'], 'Created WorkingHour must have id specified');
        $this->assertNotNull(WorkingHour::find($createdWorkingHour['id']), 'WorkingHour with given id must be in DB');
        $this->assertModelData($workingHour, $createdWorkingHour);
    }

    /**
     * @test read
     */
    public function testReadWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $dbWorkingHour = $this->workingHourRepo->find($workingHour->id);
        $dbWorkingHour = $dbWorkingHour->toArray();
        $this->assertModelData($workingHour->toArray(), $dbWorkingHour);
    }

    /**
     * @test update
     */
    public function testUpdateWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $fakeWorkingHour = $this->fakeWorkingHourData();
        $updatedWorkingHour = $this->workingHourRepo->update($fakeWorkingHour, $workingHour->id);
        $this->assertModelData($fakeWorkingHour, $updatedWorkingHour->toArray());
        $dbWorkingHour = $this->workingHourRepo->find($workingHour->id);
        $this->assertModelData($fakeWorkingHour, $dbWorkingHour->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $resp = $this->workingHourRepo->delete($workingHour->id);
        $this->assertTrue($resp);
        $this->assertNull(WorkingHour::find($workingHour->id), 'WorkingHour should not exist in DB');
    }
}

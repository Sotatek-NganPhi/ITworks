<?php

use App\Models\JobGroup;
use App\Repositories\JobGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobGroupRepositoryTest extends TestCase
{
    use MakeJobGroupTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobGroupRepository
     */
    protected $jobGroupRepo;

    public function setUp()
    {
        parent::setUp();
        $this->jobGroupRepo = App::make(JobGroupRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateJobGroup()
    {
        $jobGroup = $this->fakeJobGroupData();
        $createdJobGroup = $this->jobGroupRepo->create($jobGroup);
        $createdJobGroup = $createdJobGroup->toArray();
        $this->assertArrayHasKey('id', $createdJobGroup);
        $this->assertNotNull($createdJobGroup['id'], 'Created JobGroup must have id specified');
        $this->assertNotNull(JobGroup::find($createdJobGroup['id']), 'JobGroup with given id must be in DB');
        $this->assertModelData($jobGroup, $createdJobGroup);
    }

    /**
     * @test read
     */
    public function testReadJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $dbJobGroup = $this->jobGroupRepo->find($jobGroup->id);
        $dbJobGroup = $dbJobGroup->toArray();
        $this->assertModelData($jobGroup->toArray(), $dbJobGroup);
    }

    /**
     * @test update
     */
    public function testUpdateJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $fakeJobGroup = $this->fakeJobGroupData();
        $updatedJobGroup = $this->jobGroupRepo->update($fakeJobGroup, $jobGroup->id);
        $this->assertModelData($fakeJobGroup, $updatedJobGroup->toArray());
        $dbJobGroup = $this->jobGroupRepo->find($jobGroup->id);
        $this->assertModelData($fakeJobGroup, $dbJobGroup->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $resp = $this->jobGroupRepo->delete($jobGroup->id);
        $this->assertTrue($resp);
        $this->assertNull(JobGroup::find($jobGroup->id), 'JobGroup should not exist in DB');
    }
}

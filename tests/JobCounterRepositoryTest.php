<?php

use App\Models\JobCounter;
use App\Repositories\JobCounterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobCounterRepositoryTest extends TestCase
{
    use MakeJobCounterTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobCounterRepository
     */
    protected $jobCounterRepo;

    public function setUp()
    {
        parent::setUp();
        $this->jobCounterRepo = App::make(JobCounterRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateJobCounter()
    {
        $jobCounter = $this->fakeJobCounterData();
        $createdJobCounter = $this->jobCounterRepo->create($jobCounter);
        $createdJobCounter = $createdJobCounter->toArray();
        $this->assertArrayHasKey('id', $createdJobCounter);
        $this->assertNotNull($createdJobCounter['id'], 'Created JobCounter must have id specified');
        $this->assertNotNull(JobCounter::find($createdJobCounter['id']), 'JobCounter with given id must be in DB');
        $this->assertModelData($jobCounter, $createdJobCounter);
    }

    /**
     * @test read
     */
    public function testReadJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $dbJobCounter = $this->jobCounterRepo->find($jobCounter->id);
        $dbJobCounter = $dbJobCounter->toArray();
        $this->assertModelData($jobCounter->toArray(), $dbJobCounter);
    }

    /**
     * @test update
     */
    public function testUpdateJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $fakeJobCounter = $this->fakeJobCounterData();
        $updatedJobCounter = $this->jobCounterRepo->update($fakeJobCounter, $jobCounter->id);
        $this->assertModelData($fakeJobCounter, $updatedJobCounter->toArray());
        $dbJobCounter = $this->jobCounterRepo->find($jobCounter->id);
        $this->assertModelData($fakeJobCounter, $dbJobCounter->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $resp = $this->jobCounterRepo->delete($jobCounter->id);
        $this->assertTrue($resp);
        $this->assertNull(JobCounter::find($jobCounter->id), 'JobCounter should not exist in DB');
    }
}

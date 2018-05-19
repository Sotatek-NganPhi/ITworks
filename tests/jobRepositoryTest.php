<?php

use App\Models\Job;
use App\Repositories\JobRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class jobRepositoryTest extends TestCase
{
    use MakejobTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobRepository
     */
    protected $jobRepo;

    public function setUp()
    {
        parent::setUp();
        $this->jobRepo = App::make(JobRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatejob()
    {
        $job = $this->fakejobData();
        $createdjob = $this->jobRepo->create($job);
        $createdjob = $createdjob->toArray();
        $this->assertArrayHasKey('id', $createdjob);
        $this->assertNotNull($createdjob['id'], 'Created job must have id specified');
        $this->assertNotNull(job::find($createdjob['id']), 'job with given id must be in DB');
        $this->assertModelData($job, $createdjob);
    }

    /**
     * @test read
     */
    public function testReadjob()
    {
        $job = $this->makejob();
        $dbjob = $this->jobRepo->find($job->id);
        $dbjob = $dbjob->toArray();
        $this->assertModelData($job->toArray(), $dbjob);
    }

    /**
     * @test update
     */
    public function testUpdatejob()
    {
        $job = $this->makejob();
        $fakejob = $this->fakejobData();
        $updatedjob = $this->jobRepo->update($fakejob, $job->id);
        $this->assertModelData($fakejob, $updatedjob->toArray());
        $dbjob = $this->jobRepo->find($job->id);
        $this->assertModelData($fakejob, $dbjob->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletejob()
    {
        $job = $this->makejob();
        $resp = $this->jobRepo->delete($job->id);
        $this->assertTrue($resp);
        $this->assertNull(job::find($job->id), 'job should not exist in DB');
    }
}

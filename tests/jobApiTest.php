<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class jobApiTest extends TestCase
{
    use MakejobTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatejob()
    {
        $job = $this->fakejobData();
        $this->json('POST', '/api/v1/jobs', $job);

        $this->assertApiResponse($job);
    }

    /**
     * @test
     */
    public function testReadjob()
    {
        $job = $this->makejob();
        $this->json('GET', '/api/v1/jobs/'.$job->id);

        $this->assertApiResponse($job->toArray());
    }

    /**
     * @test
     */
    public function testUpdatejob()
    {
        $job = $this->makejob();
        $editedjob = $this->fakejobData();

        $this->json('PUT', '/api/v1/jobs/'.$job->id, $editedjob);

        $this->assertApiResponse($editedjob);
    }

    /**
     * @test
     */
    public function testDeletejob()
    {
        $job = $this->makejob();
        $this->json('DELETE', '/api/v1/jobs/'.$job->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/jobs/'.$job->id);

        $this->assertResponseStatus(404);
    }
}

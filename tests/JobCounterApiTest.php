<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobCounterApiTest extends TestCase
{
    use MakeJobCounterTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateJobCounter()
    {
        $jobCounter = $this->fakeJobCounterData();
        $this->json('POST', '/api/v1/jobCounters', $jobCounter);

        $this->assertApiResponse($jobCounter);
    }

    /**
     * @test
     */
    public function testReadJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $this->json('GET', '/api/v1/jobCounters/'.$jobCounter->id);

        $this->assertApiResponse($jobCounter->toArray());
    }

    /**
     * @test
     */
    public function testUpdateJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $editedJobCounter = $this->fakeJobCounterData();

        $this->json('PUT', '/api/v1/jobCounters/'.$jobCounter->id, $editedJobCounter);

        $this->assertApiResponse($editedJobCounter);
    }

    /**
     * @test
     */
    public function testDeleteJobCounter()
    {
        $jobCounter = $this->makeJobCounter();
        $this->json('DELETE', '/api/v1/jobCounters/'.$jobCounter->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/jobCounters/'.$jobCounter->id);

        $this->assertResponseStatus(404);
    }
}

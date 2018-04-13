<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobGroupApiTest extends TestCase
{
    use MakeJobGroupTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateJobGroup()
    {
        $jobGroup = $this->fakeJobGroupData();
        $this->json('POST', '/api/v1/jobGroups', $jobGroup);

        $this->assertApiResponse($jobGroup);
    }

    /**
     * @test
     */
    public function testReadJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $this->json('GET', '/api/v1/jobGroups/'.$jobGroup->id);

        $this->assertApiResponse($jobGroup->toArray());
    }

    /**
     * @test
     */
    public function testUpdateJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $editedJobGroup = $this->fakeJobGroupData();

        $this->json('PUT', '/api/v1/jobGroups/'.$jobGroup->id, $editedJobGroup);

        $this->assertApiResponse($editedJobGroup);
    }

    /**
     * @test
     */
    public function testDeleteJobGroup()
    {
        $jobGroup = $this->makeJobGroup();
        $this->json('DELETE', '/api/v1/jobGroups/'.$jobGroup->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/jobGroups/'.$jobGroup->id);

        $this->assertResponseStatus(404);
    }
}

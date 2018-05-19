<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingPeriodApiTest extends TestCase
{
    use MakeWorkingPeriodTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWorkingPeriod()
    {
        $workingPeriod = $this->fakeWorkingPeriodData();
        $this->json('POST', '/api/v1/workingPeriods', $workingPeriod);

        $this->assertApiResponse($workingPeriod);
    }

    /**
     * @test
     */
    public function testReadWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $this->json('GET', '/api/v1/workingPeriods/'.$workingPeriod->id);

        $this->assertApiResponse($workingPeriod->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $editedWorkingPeriod = $this->fakeWorkingPeriodData();

        $this->json('PUT', '/api/v1/workingPeriods/'.$workingPeriod->id, $editedWorkingPeriod);

        $this->assertApiResponse($editedWorkingPeriod);
    }

    /**
     * @test
     */
    public function testDeleteWorkingPeriod()
    {
        $workingPeriod = $this->makeWorkingPeriod();
        $this->json('DELETE', '/api/v1/workingPeriods/'.$workingPeriod->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/workingPeriods/'.$workingPeriod->id);

        $this->assertResponseStatus(404);
    }
}

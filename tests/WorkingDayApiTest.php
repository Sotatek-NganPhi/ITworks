<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingDayApiTest extends TestCase
{
    use MakeWorkingDayTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWorkingDay()
    {
        $workingDay = $this->fakeWorkingDayData();
        $this->json('POST', '/api/v1/workingDays', $workingDay);

        $this->assertApiResponse($workingDay);
    }

    /**
     * @test
     */
    public function testReadWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $this->json('GET', '/api/v1/workingDays/'.$workingDay->id);

        $this->assertApiResponse($workingDay->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $editedWorkingDay = $this->fakeWorkingDayData();

        $this->json('PUT', '/api/v1/workingDays/'.$workingDay->id, $editedWorkingDay);

        $this->assertApiResponse($editedWorkingDay);
    }

    /**
     * @test
     */
    public function testDeleteWorkingDay()
    {
        $workingDay = $this->makeWorkingDay();
        $this->json('DELETE', '/api/v1/workingDays/'.$workingDay->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/workingDays/'.$workingDay->id);

        $this->assertResponseStatus(404);
    }
}

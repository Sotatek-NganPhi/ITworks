<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingHourApiTest extends TestCase
{
    use MakeWorkingHourTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWorkingHour()
    {
        $workingHour = $this->fakeWorkingHourData();
        $this->json('POST', '/api/v1/workingHours', $workingHour);

        $this->assertApiResponse($workingHour);
    }

    /**
     * @test
     */
    public function testReadWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $this->json('GET', '/api/v1/workingHours/'.$workingHour->id);

        $this->assertApiResponse($workingHour->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $editedWorkingHour = $this->fakeWorkingHourData();

        $this->json('PUT', '/api/v1/workingHours/'.$workingHour->id, $editedWorkingHour);

        $this->assertApiResponse($editedWorkingHour);
    }

    /**
     * @test
     */
    public function testDeleteWorkingHour()
    {
        $workingHour = $this->makeWorkingHour();
        $this->json('DELETE', '/api/v1/workingHours/'.$workingHour->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/workingHours/'.$workingHour->id);

        $this->assertResponseStatus(404);
    }
}

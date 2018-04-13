<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkingShiftApiTest extends TestCase
{
    use MakeWorkingShiftTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWorkingShift()
    {
        $workingShift = $this->fakeWorkingShiftData();
        $this->json('POST', '/api/v1/workingShifts', $workingShift);

        $this->assertApiResponse($workingShift);
    }

    /**
     * @test
     */
    public function testReadWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $this->json('GET', '/api/v1/workingShifts/'.$workingShift->id);

        $this->assertApiResponse($workingShift->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $editedWorkingShift = $this->fakeWorkingShiftData();

        $this->json('PUT', '/api/v1/workingShifts/'.$workingShift->id, $editedWorkingShift);

        $this->assertApiResponse($editedWorkingShift);
    }

    /**
     * @test
     */
    public function testDeleteWorkingShift()
    {
        $workingShift = $this->makeWorkingShift();
        $this->json('DELETE', '/api/v1/workingShifts/'.$workingShift->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/workingShifts/'.$workingShift->id);

        $this->assertResponseStatus(404);
    }
}

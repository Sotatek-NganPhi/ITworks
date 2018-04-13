<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmploymentModeApiTest extends TestCase
{
    use MakeEmploymentModeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateEmploymentMode()
    {
        $employmentMode = $this->fakeEmploymentModeData();
        $this->json('POST', '/api/v1/employmentModes', $employmentMode);

        $this->assertApiResponse($employmentMode);
    }

    /**
     * @test
     */
    public function testReadEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $this->json('GET', '/api/v1/employmentModes/'.$employmentMode->id);

        $this->assertApiResponse($employmentMode->toArray());
    }

    /**
     * @test
     */
    public function testUpdateEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $editedEmploymentMode = $this->fakeEmploymentModeData();

        $this->json('PUT', '/api/v1/employmentModes/'.$employmentMode->id, $editedEmploymentMode);

        $this->assertApiResponse($editedEmploymentMode);
    }

    /**
     * @test
     */
    public function testDeleteEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $this->json('DELETE', '/api/v1/employmentModes/'.$employmentMode->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/employmentModes/'.$employmentMode->id);

        $this->assertResponseStatus(404);
    }
}

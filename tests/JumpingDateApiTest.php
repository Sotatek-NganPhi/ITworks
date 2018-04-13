<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JumpingDateApiTest extends TestCase
{
    use MakeJumpingDateTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateJumpingDate()
    {
        $jumpingDate = $this->fakeJumpingDateData();
        $this->json('POST', '/api/v1/jumpingDates', $jumpingDate);

        $this->assertApiResponse($jumpingDate);
    }

    /**
     * @test
     */
    public function testReadJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $this->json('GET', '/api/v1/jumpingDates/'.$jumpingDate->id);

        $this->assertApiResponse($jumpingDate->toArray());
    }

    /**
     * @test
     */
    public function testUpdateJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $editedJumpingDate = $this->fakeJumpingDateData();

        $this->json('PUT', '/api/v1/jumpingDates/'.$jumpingDate->id, $editedJumpingDate);

        $this->assertApiResponse($editedJumpingDate);
    }

    /**
     * @test
     */
    public function testDeleteJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $this->json('DELETE', '/api/v1/jumpingDates/'.$jumpingDate->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/jumpingDates/'.$jumpingDate->id);

        $this->assertResponseStatus(404);
    }
}

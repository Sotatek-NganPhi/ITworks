<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InterviewApiTest extends TestCase
{
    use MakeInterviewTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateInterview()
    {
        $interview = $this->fakeInterviewData();
        $this->json('POST', '/api/v1/interviews', $interview);

        $this->assertApiResponse($interview);
    }

    /**
     * @test
     */
    public function testReadInterview()
    {
        $interview = $this->makeInterview();
        $this->json('GET', '/api/v1/interviews/'.$interview->id);

        $this->assertApiResponse($interview->toArray());
    }

    /**
     * @test
     */
    public function testUpdateInterview()
    {
        $interview = $this->makeInterview();
        $editedInterview = $this->fakeInterviewData();

        $this->json('PUT', '/api/v1/interviews/'.$interview->id, $editedInterview);

        $this->assertApiResponse($editedInterview);
    }

    /**
     * @test
     */
    public function testDeleteInterview()
    {
        $interview = $this->makeInterview();
        $this->json('DELETE', '/api/v1/interviews/'.$interview->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/interviews/'.$interview->id);

        $this->assertResponseStatus(404);
    }
}

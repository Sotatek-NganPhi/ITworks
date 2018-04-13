<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CandidateApiTest extends TestCase
{
    use MakeCandidateTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCandidate()
    {
        $candidate = $this->fakeCandidateData();
        $this->json('POST', '/api/v1/candidates', $candidate);

        $this->assertApiResponse($candidate);
    }

    /**
     * @test
     */
    public function testReadCandidate()
    {
        $candidate = $this->makeCandidate();
        $this->json('GET', '/api/v1/candidates/'.$candidate->id);

        $this->assertApiResponse($candidate->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCandidate()
    {
        $candidate = $this->makeCandidate();
        $editedCandidate = $this->fakeCandidateData();

        $this->json('PUT', '/api/v1/candidates/'.$candidate->id, $editedCandidate);

        $this->assertApiResponse($editedCandidate);
    }

    /**
     * @test
     */
    public function testDeleteCandidate()
    {
        $candidate = $this->makeCandidate();
        $this->json('DELETE', '/api/v1/candidates/'.$candidate->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/candidates/'.$candidate->id);

        $this->assertResponseStatus(404);
    }
}

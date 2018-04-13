<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicantApiTest extends TestCase
{
    use MakeApplicantTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateApplicant()
    {
        $applicant = $this->fakeApplicantData();
        $this->json('POST', '/api/v1/applicants', $applicant);

        $this->assertApiResponse($applicant);
    }

    /**
     * @test
     */
    public function testReadApplicant()
    {
        $applicant = $this->makeApplicant();
        $this->json('GET', '/api/v1/applicants/'.$applicant->id);

        $this->assertApiResponse($applicant->toArray());
    }

    /**
     * @test
     */
    public function testUpdateApplicant()
    {
        $applicant = $this->makeApplicant();
        $editedApplicant = $this->fakeApplicantData();

        $this->json('PUT', '/api/v1/applicants/'.$applicant->id, $editedApplicant);

        $this->assertApiResponse($editedApplicant);
    }

    /**
     * @test
     */
    public function testDeleteApplicant()
    {
        $applicant = $this->makeApplicant();
        $this->json('DELETE', '/api/v1/applicants/'.$applicant->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/applicants/'.$applicant->id);

        $this->assertResponseStatus(404);
    }
}

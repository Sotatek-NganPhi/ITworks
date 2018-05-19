<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EducationApiTest extends TestCase
{
    use MakeEducationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateEducation()
    {
        $education = $this->fakeEducationData();
        $this->json('POST', '/api/v1/education', $education);

        $this->assertApiResponse($education);
    }

    /**
     * @test
     */
    public function testReadEducation()
    {
        $education = $this->makeEducation();
        $this->json('GET', '/api/v1/education/'.$education->id);

        $this->assertApiResponse($education->toArray());
    }

    /**
     * @test
     */
    public function testUpdateEducation()
    {
        $education = $this->makeEducation();
        $editedEducation = $this->fakeEducationData();

        $this->json('PUT', '/api/v1/education/'.$education->id, $editedEducation);

        $this->assertApiResponse($editedEducation);
    }

    /**
     * @test
     */
    public function testDeleteEducation()
    {
        $education = $this->makeEducation();
        $this->json('DELETE', '/api/v1/education/'.$education->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/education/'.$education->id);

        $this->assertResponseStatus(404);
    }
}

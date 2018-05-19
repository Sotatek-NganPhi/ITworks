<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanySizeApiTest extends TestCase
{
    use MakeCompanySizeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCompanySize()
    {
        $companySize = $this->fakeCompanySizeData();
        $this->json('POST', '/api/v1/companySizes', $companySize);

        $this->assertApiResponse($companySize);
    }

    /**
     * @test
     */
    public function testReadCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $this->json('GET', '/api/v1/companySizes/'.$companySize->id);

        $this->assertApiResponse($companySize->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $editedCompanySize = $this->fakeCompanySizeData();

        $this->json('PUT', '/api/v1/companySizes/'.$companySize->id, $editedCompanySize);

        $this->assertApiResponse($editedCompanySize);
    }

    /**
     * @test
     */
    public function testDeleteCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $this->json('DELETE', '/api/v1/companySizes/'.$companySize->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/companySizes/'.$companySize->id);

        $this->assertResponseStatus(404);
    }
}

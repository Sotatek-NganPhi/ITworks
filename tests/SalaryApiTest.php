<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SalaryApiTest extends TestCase
{
    use MakeSalaryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSalary()
    {
        $salary = $this->fakeSalaryData();
        $this->json('POST', '/api/v1/salaries', $salary);

        $this->assertApiResponse($salary);
    }

    /**
     * @test
     */
    public function testReadSalary()
    {
        $salary = $this->makeSalary();
        $this->json('GET', '/api/v1/salaries/'.$salary->id);

        $this->assertApiResponse($salary->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSalary()
    {
        $salary = $this->makeSalary();
        $editedSalary = $this->fakeSalaryData();

        $this->json('PUT', '/api/v1/salaries/'.$salary->id, $editedSalary);

        $this->assertApiResponse($editedSalary);
    }

    /**
     * @test
     */
    public function testDeleteSalary()
    {
        $salary = $this->makeSalary();
        $this->json('DELETE', '/api/v1/salaries/'.$salary->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/salaries/'.$salary->id);

        $this->assertResponseStatus(404);
    }
}

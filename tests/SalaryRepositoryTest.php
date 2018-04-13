<?php

use App\Models\Salary;
use App\Repositories\SalaryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SalaryRepositoryTest extends TestCase
{
    use MakeSalaryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryRepository
     */
    protected $salaryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->salaryRepo = App::make(SalaryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSalary()
    {
        $salary = $this->fakeSalaryData();
        $createdSalary = $this->salaryRepo->create($salary);
        $createdSalary = $createdSalary->toArray();
        $this->assertArrayHasKey('id', $createdSalary);
        $this->assertNotNull($createdSalary['id'], 'Created Salary must have id specified');
        $this->assertNotNull(Salary::find($createdSalary['id']), 'Salary with given id must be in DB');
        $this->assertModelData($salary, $createdSalary);
    }

    /**
     * @test read
     */
    public function testReadSalary()
    {
        $salary = $this->makeSalary();
        $dbSalary = $this->salaryRepo->find($salary->id);
        $dbSalary = $dbSalary->toArray();
        $this->assertModelData($salary->toArray(), $dbSalary);
    }

    /**
     * @test update
     */
    public function testUpdateSalary()
    {
        $salary = $this->makeSalary();
        $fakeSalary = $this->fakeSalaryData();
        $updatedSalary = $this->salaryRepo->update($fakeSalary, $salary->id);
        $this->assertModelData($fakeSalary, $updatedSalary->toArray());
        $dbSalary = $this->salaryRepo->find($salary->id);
        $this->assertModelData($fakeSalary, $dbSalary->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSalary()
    {
        $salary = $this->makeSalary();
        $resp = $this->salaryRepo->delete($salary->id);
        $this->assertTrue($resp);
        $this->assertNull(Salary::find($salary->id), 'Salary should not exist in DB');
    }
}

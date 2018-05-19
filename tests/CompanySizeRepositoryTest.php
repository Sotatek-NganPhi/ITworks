<?php

use App\Models\CompanySize;
use App\Repositories\CompanySizeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanySizeRepositoryTest extends TestCase
{
    use MakeCompanySizeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CompanySizeRepository
     */
    protected $companySizeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->companySizeRepo = App::make(CompanySizeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCompanySize()
    {
        $companySize = $this->fakeCompanySizeData();
        $createdCompanySize = $this->companySizeRepo->create($companySize);
        $createdCompanySize = $createdCompanySize->toArray();
        $this->assertArrayHasKey('id', $createdCompanySize);
        $this->assertNotNull($createdCompanySize['id'], 'Created CompanySize must have id specified');
        $this->assertNotNull(CompanySize::find($createdCompanySize['id']), 'CompanySize with given id must be in DB');
        $this->assertModelData($companySize, $createdCompanySize);
    }

    /**
     * @test read
     */
    public function testReadCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $dbCompanySize = $this->companySizeRepo->find($companySize->id);
        $dbCompanySize = $dbCompanySize->toArray();
        $this->assertModelData($companySize->toArray(), $dbCompanySize);
    }

    /**
     * @test update
     */
    public function testUpdateCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $fakeCompanySize = $this->fakeCompanySizeData();
        $updatedCompanySize = $this->companySizeRepo->update($fakeCompanySize, $companySize->id);
        $this->assertModelData($fakeCompanySize, $updatedCompanySize->toArray());
        $dbCompanySize = $this->companySizeRepo->find($companySize->id);
        $this->assertModelData($fakeCompanySize, $dbCompanySize->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCompanySize()
    {
        $companySize = $this->makeCompanySize();
        $resp = $this->companySizeRepo->delete($companySize->id);
        $this->assertTrue($resp);
        $this->assertNull(CompanySize::find($companySize->id), 'CompanySize should not exist in DB');
    }
}

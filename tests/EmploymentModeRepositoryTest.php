<?php

use App\Models\EmploymentMode;
use App\Repositories\EmploymentModeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmploymentModeRepositoryTest extends TestCase
{
    use MakeEmploymentModeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var EmploymentModeRepository
     */
    protected $employmentModeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->employmentModeRepo = App::make(EmploymentModeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateEmploymentMode()
    {
        $employmentMode = $this->fakeEmploymentModeData();
        $createdEmploymentMode = $this->employmentModeRepo->create($employmentMode);
        $createdEmploymentMode = $createdEmploymentMode->toArray();
        $this->assertArrayHasKey('id', $createdEmploymentMode);
        $this->assertNotNull($createdEmploymentMode['id'], 'Created EmploymentMode must have id specified');
        $this->assertNotNull(EmploymentMode::find($createdEmploymentMode['id']), 'EmploymentMode with given id must be in DB');
        $this->assertModelData($employmentMode, $createdEmploymentMode);
    }

    /**
     * @test read
     */
    public function testReadEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $dbEmploymentMode = $this->employmentModeRepo->find($employmentMode->id);
        $dbEmploymentMode = $dbEmploymentMode->toArray();
        $this->assertModelData($employmentMode->toArray(), $dbEmploymentMode);
    }

    /**
     * @test update
     */
    public function testUpdateEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $fakeEmploymentMode = $this->fakeEmploymentModeData();
        $updatedEmploymentMode = $this->employmentModeRepo->update($fakeEmploymentMode, $employmentMode->id);
        $this->assertModelData($fakeEmploymentMode, $updatedEmploymentMode->toArray());
        $dbEmploymentMode = $this->employmentModeRepo->find($employmentMode->id);
        $this->assertModelData($fakeEmploymentMode, $dbEmploymentMode->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteEmploymentMode()
    {
        $employmentMode = $this->makeEmploymentMode();
        $resp = $this->employmentModeRepo->delete($employmentMode->id);
        $this->assertTrue($resp);
        $this->assertNull(EmploymentMode::find($employmentMode->id), 'EmploymentMode should not exist in DB');
    }
}

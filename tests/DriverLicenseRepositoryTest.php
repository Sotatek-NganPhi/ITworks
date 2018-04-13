<?php

use App\Models\DriverLicense;
use App\Repositories\DriverLicenseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DriverLicenseRepositoryTest extends TestCase
{
    use MakeDriverLicenseTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DriverLicenseRepository
     */
    protected $driverLicenseRepo;

    public function setUp()
    {
        parent::setUp();
        $this->driverLicenseRepo = App::make(DriverLicenseRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDriverLicense()
    {
        $driverLicense = $this->fakeDriverLicenseData();
        $createdDriverLicense = $this->driverLicenseRepo->create($driverLicense);
        $createdDriverLicense = $createdDriverLicense->toArray();
        $this->assertArrayHasKey('id', $createdDriverLicense);
        $this->assertNotNull($createdDriverLicense['id'], 'Created DriverLicense must have id specified');
        $this->assertNotNull(DriverLicense::find($createdDriverLicense['id']), 'DriverLicense with given id must be in DB');
        $this->assertModelData($driverLicense, $createdDriverLicense);
    }

    /**
     * @test read
     */
    public function testReadDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $dbDriverLicense = $this->driverLicenseRepo->find($driverLicense->id);
        $dbDriverLicense = $dbDriverLicense->toArray();
        $this->assertModelData($driverLicense->toArray(), $dbDriverLicense);
    }

    /**
     * @test update
     */
    public function testUpdateDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $fakeDriverLicense = $this->fakeDriverLicenseData();
        $updatedDriverLicense = $this->driverLicenseRepo->update($fakeDriverLicense, $driverLicense->id);
        $this->assertModelData($fakeDriverLicense, $updatedDriverLicense->toArray());
        $dbDriverLicense = $this->driverLicenseRepo->find($driverLicense->id);
        $this->assertModelData($fakeDriverLicense, $dbDriverLicense->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $resp = $this->driverLicenseRepo->delete($driverLicense->id);
        $this->assertTrue($resp);
        $this->assertNull(DriverLicense::find($driverLicense->id), 'DriverLicense should not exist in DB');
    }
}

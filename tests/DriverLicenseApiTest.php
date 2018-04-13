<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DriverLicenseApiTest extends TestCase
{
    use MakeDriverLicenseTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDriverLicense()
    {
        $driverLicense = $this->fakeDriverLicenseData();
        $this->json('POST', '/api/v1/driverLicenses', $driverLicense);

        $this->assertApiResponse($driverLicense);
    }

    /**
     * @test
     */
    public function testReadDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $this->json('GET', '/api/v1/driverLicenses/'.$driverLicense->id);

        $this->assertApiResponse($driverLicense->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $editedDriverLicense = $this->fakeDriverLicenseData();

        $this->json('PUT', '/api/v1/driverLicenses/'.$driverLicense->id, $editedDriverLicense);

        $this->assertApiResponse($editedDriverLicense);
    }

    /**
     * @test
     */
    public function testDeleteDriverLicense()
    {
        $driverLicense = $this->makeDriverLicense();
        $this->json('DELETE', '/api/v1/driverLicenses/'.$driverLicense->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/driverLicenses/'.$driverLicense->id);

        $this->assertResponseStatus(404);
    }
}

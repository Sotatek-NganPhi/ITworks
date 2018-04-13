<?php

use Faker\Factory as Faker;
use App\Models\DriverLicense;
use App\Repositories\DriverLicenseRepository;

trait MakeDriverLicenseTrait
{
    /**
     * Create fake instance of DriverLicense and save it in database
     *
     * @param array $driverLicenseFields
     * @return DriverLicense
     */
    public function makeDriverLicense($driverLicenseFields = [])
    {
        /** @var DriverLicenseRepository $driverLicenseRepo */
        $driverLicenseRepo = App::make(DriverLicenseRepository::class);
        $theme = $this->fakeDriverLicenseData($driverLicenseFields);
        return $driverLicenseRepo->create($theme);
    }

    /**
     * Get fake instance of DriverLicense
     *
     * @param array $driverLicenseFields
     * @return DriverLicense
     */
    public function fakeDriverLicense($driverLicenseFields = [])
    {
        return new DriverLicense($this->fakeDriverLicenseData($driverLicenseFields));
    }

    /**
     * Get fake data of DriverLicense
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDriverLicenseData($driverLicenseFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $driverLicenseFields);
    }
}

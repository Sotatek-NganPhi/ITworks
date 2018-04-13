<?php

use Faker\Factory as Faker;
use App\Models\CompanySize;
use App\Repositories\CompanySizeRepository;

trait MakeCompanySizeTrait
{
    /**
     * Create fake instance of CompanySize and save it in database
     *
     * @param array $companySizeFields
     * @return CompanySize
     */
    public function makeCompanySize($companySizeFields = [])
    {
        /** @var CompanySizeRepository $companySizeRepo */
        $companySizeRepo = App::make(CompanySizeRepository::class);
        $theme = $this->fakeCompanySizeData($companySizeFields);
        return $companySizeRepo->create($theme);
    }

    /**
     * Get fake instance of CompanySize
     *
     * @param array $companySizeFields
     * @return CompanySize
     */
    public function fakeCompanySize($companySizeFields = [])
    {
        return new CompanySize($this->fakeCompanySizeData($companySizeFields));
    }

    /**
     * Get fake data of CompanySize
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCompanySizeData($companySizeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'min' => $fake->randomDigitNotNull,
            'max' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $companySizeFields);
    }
}

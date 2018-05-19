<?php

use Faker\Factory as Faker;
use App\Models\Salary;
use App\Repositories\SalaryRepository;

trait MakeSalaryTrait
{
    /**
     * Create fake instance of Salary and save it in database
     *
     * @param array $salaryFields
     * @return Salary
     */
    public function makeSalary($salaryFields = [])
    {
        /** @var SalaryRepository $salaryRepo */
        $salaryRepo = App::make(SalaryRepository::class);
        $theme = $this->fakeSalaryData($salaryFields);
        return $salaryRepo->create($theme);
    }

    /**
     * Get fake instance of Salary
     *
     * @param array $salaryFields
     * @return Salary
     */
    public function fakeSalary($salaryFields = [])
    {
        return new Salary($this->fakeSalaryData($salaryFields));
    }

    /**
     * Get fake data of Salary
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSalaryData($salaryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $salaryFields);
    }
}

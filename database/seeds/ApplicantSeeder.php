<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\CurrentSituation;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for($i = 0; $i < 30; $i ++) {
            $data[] = [
                'job_id' => rand(1, 20),
                'user_id' => rand(1, 4),
                'email' => 'test@gmail.com',
                'first_name'                     => "TEST",
                'last_name'                      => "TEST",
                'first_name_phonetic'            => "TEST",
                'last_name_phonetic'             => "10000",
                'postal_code'                    => "123",
                'address'                        => "HANOI",
                'phone_number'                   => "12312312312",
                'gender'                         => "male",
                'current_situation_id'           => "1",
                'education_id'                   => "1",
                'final_academic_school'          => "TEST",
                'graduated_at'                   => Carbon::now()->toDateString(),
                'toeic'                          => "1",
                'toefl'                          => "1",
                'language_experience_id'         => "1",
                'language_conversation_level_id' => "1",
                'driver_license_id'              => "1",
                'worked_companies_number'        => "1",
                'lastest_industry_id'            => "1",
                'lastest_annual_income'          => "1",
                'lastest_job_description'        => "1",
                'resume_pr'                      => "TEST",
                'lastest_company_name'           => "TEST",
            ];
        }
        DB::table('applicants')->insert($data);
    }
}

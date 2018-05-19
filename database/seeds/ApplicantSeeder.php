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
                'address'                        => "HANOI",
                'phone_number'                   => "12312312312",
                'gender'                         => "male",
                'education_id'                   => "1",
                'final_academic_school'          => "TEST",
                'graduated_at'                   => Carbon::now()->toDateString(),
                'toeic'                          => "1",
                'toefl'                          => "1",
                'language_experience_id'         => "1",
                'language_conversation_level_id' => "1",
            ];
        }
        DB::table('applicants')->insert($data);
    }
}

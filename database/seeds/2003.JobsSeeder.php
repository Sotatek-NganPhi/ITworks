<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

ini_set('memory_limit', '512M');

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('job_counters')->truncate();
        DB::table('job_prefecture')->truncate();
        DB::table('jobs')->truncate();
        DB::table('companies')->truncate();

        $COMPANY_MIN = 70;
        $COMPANY_MAX = 100;
        $JOB_PER_COMPANY_MIN = 30;
        $JOB_PER_COMPANY_MAX = 50;
        $LINKING_PROB = 50;
        $companies = [];
        $jobs = [];
        $jobCounters = [];
        $jobSituations = [];
        $jobPrefectures = [];
    
        $prefectureIds = App\Models\Prefecture::getAll()->pluck('id')->toArray();

        $companyId = 0;
        $jobId = 0;

        $companyCount = rand($COMPANY_MIN, $COMPANY_MAX);
        for ($c = 0; $c < $companyCount; $c++) {
            $companyId++;
            $companies[] = [
                'id'                    => $companyId,
                'name'                  => $faker->company,
                'street_address'        => $faker->streetAddress,
                'contact_name'          => $faker->name,
                'phone_number'          => $faker->numerify("###########"),
                'short_description'     => $faker->sentence,
                'business_content'      => $faker->paragraph,
                'email'                 => $faker->email,
                'created_at'            => $faker->dateTime(),
                'updated_at'            => $faker->dateTime(),
            ];

            $jobCount = rand($JOB_PER_COMPANY_MIN, $JOB_PER_COMPANY_MAX);
            for ($j = 0; $j < $jobCount; $j++) {
                $jobId++;
                $postStartDate = $faker->dateTimeThisYear('-2 month');
                $postEndDate   = $faker->dateTimeBetween($postStartDate, strtotime('+1 month'));
                $jobs[] = [
                    'id'                    => $jobId,
                    'company_id'            => $companyId,
                    'description'           => $faker->paragraph,
                    'post_start_date'       => $postStartDate,
                    'post_end_date'         => $postEndDate,
                    'salary'                => $faker->paragraph,
                    'application_condition' => $faker->sentence,
                    'message'               => $faker->sentence,
                    'main_image'            => $faker->imageUrl(640, 240),
                    'main_caption'          => $faker->sentence,
                    'email_receive_applicant' => $faker->email,
                    'created_at'            => $faker->dateTime(),
                    'updated_at'            => $faker->dateTime(),
                ];
            }

            for ($day = 0; $day < 100; $day++) {
                $jobCounters[] = [
                    'job_id' => $jobId,
                    'view_date' => Carbon::now(App\Consts::TIME_ZONE_VIETNAM)->subDays($day),
                    'views' => rand(100, 1000)
                ];
            }

            $sampleIds = $faker->randomElements($prefectureIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobPrefectures[] = [
                    'job_id'        => $jobId,
                    'prefecture_id' => $value,
                ];
            }

        }

        printf("    Inserting companies...\n");
        DB::table('companies')->insert($companies);
        foreach (\App\Models\Company::cursor() as $company) {
            $company->sycToManager();
        }

        printf("    Inserting jobs...\n");
        foreach (array_chunk($jobs, 100) as $data){
            DB::table("jobs")->insert($data);
        }

        printf("    Inserting job_counters...\n");
        foreach (array_chunk($jobCounters, 500) as $data){
            DB::table("job_counters")->insert($data);
        }
        
        printf("    Inserting job_prefecture...\n");
        foreach (array_chunk($jobPrefectures, 500) as $data){
            DB::table("job_prefecture")->insert($data);
        }
    }
}

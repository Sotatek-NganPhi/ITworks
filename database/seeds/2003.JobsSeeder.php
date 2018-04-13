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
        DB::table('job_category_level1')->truncate();
        DB::table('job_category_level2')->truncate();
        DB::table('job_category_level3')->truncate();
        DB::table('job_counters')->truncate();
        DB::table('job_current_situation')->truncate();
        DB::table('job_employment_mode')->truncate();
        DB::table('job_merit')->truncate();
        DB::table('job_prefecture')->truncate();
        DB::table('job_routes')->truncate();
        DB::table('job_salary')->truncate();
        DB::table('job_ward')->truncate();
        DB::table('job_working_day')->truncate();
        DB::table('job_working_hour')->truncate();
        DB::table('job_working_period')->truncate();
        DB::table('job_working_shift')->truncate();
        DB::table('jobs')->truncate();
        DB::table('companies')->truncate();

        $COMPANY_MIN = 70;
        $COMPANY_MAX = 100;
        $JOB_PER_COMPANY_MIN = 30;
        $JOB_PER_COMPANY_MAX = 50;
        $LINKING_PROB = 50;
        $companies = [];
        $jobs = [];
        $jobCat2s = [];
        $jobCounters = [];
        $jobSituations = [];
        $jobEmploymentModes = [];
        $jobMerits = [];
        $jobPrefectures = [];
        $jobRoutes = [];
        $jobSalaries = [];
        $jobWards = [];
        $jobWorkingDays = [];
        $jobWorkingHours = [];
        $jobWorkingPeriods = [];
        $jobWorkingShifts = [];

        $cat3Ids = App\Models\CategoryLevel3::getAll()->pluck('id')->toArray();
        $situationIds = App\Models\CurrentSituation::getAll()->pluck('id')->toArray();
        $employmentModeIds = App\Models\EmploymentMode::getAll()->pluck('id')->toArray();
        $meritIds = App\Models\Merit::getAll()->pluck('id')->toArray();
        $prefectureIds = App\Models\Prefecture::getAll()->pluck('id')->toArray();
        $lineStationIds = App\Models\LineStation::getAll()->pluck('id')->toArray();
        $salaryIds = App\Models\Salary::getAll()->pluck('id')->toArray();
        $wardIds = App\Models\Salary::getAll()->pluck('id')->toArray();
        $workingDayIds = App\Models\WorkingDay::getAll()->pluck('id')->toArray();
        $workingHourIds = App\Models\WorkingHour::getAll()->pluck('id')->toArray();
        $workingPeriodIds = App\Models\WorkingPeriod::getAll()->pluck('id')->toArray();
        $workingShiftIds = App\Models\WorkingShift::getAll()->pluck('id')->toArray();

        $companyId = 0;
        $jobId = 0;

        $companyCount = rand($COMPANY_MIN, $COMPANY_MAX);
        for ($c = 0; $c < $companyCount; $c++) {
            $companyId++;
            $companies[] = [
                'id'                    => $companyId,
                'username'              => $faker->userName,
                'password'              => '123',
                'name'                  => $faker->company,
                'name_phonetic'         => $faker->company,
                'street_address'        => $faker->streetAddress,
                'contact_name'          => $faker->name,
                'phone_number'          => $faker->numerify("###-####-####"),
                'short_description'     => $faker->sentence,
                'option_first_company'  => $faker->paragraph,
                'option_second_company' => $faker->paragraph,
                'option_third_company'  => $faker->paragraph,
                'business_content'      => $faker->paragraph,
                'company_hp'            => $faker->paragraph,
                'expire_date'           => $faker->dateTimeBetween('now', '+5 years'),
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
                    'work_no'               => $faker->sentence,
                    'description'           => $faker->paragraph,
                    'post_start_date'       => $postStartDate,
                    'post_end_date'         => $postEndDate,
                    'company_name'          => $faker->sentence,
                    'interns_start_time'    => $faker->sentence,
                    'work_main'             => $faker->paragraph,
                    'working_hours'         => $faker->sentence,
                    'seniors_hometown'      => $faker->paragraph,
                    'salary'                => $faker->paragraph,
                    'application_condition' => $faker->sentence,
                    'message'               => $faker->sentence,
                    'holiday_vacation'      => $faker->sentence,
                    'interview_place'       => $faker->sentence,
                    'receptionist'          => $faker->sentence,
                    'option_1'              => $faker->sentence,
                    'option_2'              => $faker->sentence,
                    'option_3'              => $faker->sentence,
                    'option_4'              => $faker->sentence,
                    'option_5'              => $faker->sentence,
                    'option_6'              => $faker->sentence,
                    'option_7'              => $faker->sentence,
                    'option_8'              => $faker->sentence,
                    'option_9'              => $faker->sentence,
                    'option_10'             => $faker->sentence,
                    'option_11'             => $faker->sentence,
                    'option_12'             => $faker->sentence,
                    'option_13'             => $faker->sentence,
                    'option_14'             => $faker->sentence,
                    'option_15'             => $faker->sentence,
                    'option_16'             => $faker->sentence,
                    'option_17'             => $faker->sentence,
                    'option_20'             => $faker->sentence,
                    'platform_urgent'       => rand(0,1),
                    'main_image'            => $faker->imageUrl(640, 240),
                    'main_caption'          => $faker->sentence,
                    'email_receive_applicant' => $faker->email,
                    'email_company'         => $faker->email,
                    'sales_person_mail'     => $faker->email,
                    'remarks'               => $faker->sentence,
                    'created_at'            => $faker->dateTime(),
                    'updated_at'            => $faker->dateTime(),
                ];
            }

            for ($day = 0; $day < 100; $day++) {
                $jobCounters[] = [
                    'job_id' => $jobId,
                    'view_date' => Carbon::now(App\Consts::TIME_ZONE_JAPAN)->subDays($day),
                    'views' => rand(100, 1000)
                ];
            }

            $sampleIds = $faker->randomElements($cat3Ids, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobCat2s[] = [
                    'job_id'                => $jobId,
                    'category_level3_id'    => $value,
                ];
            }

            $sampleIds = $faker->randomElements($situationIds, rand(1, 2));
            foreach ($sampleIds as $key => $value) {
                $jobSituations[] = [
                    'job_id'                => $jobId,
                    'current_situation_id'  => $value,
                ];
            }

            $sampleIds = $faker->randomElements($employmentModeIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobEmploymentModes[] = [
                    'job_id'                => $jobId,
                    'employment_mode_id'    => $value,
                ];
            }

            $sampleIds = $faker->randomElements($meritIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobMerits[] = [
                    'job_id'      => $jobId,
                    'merit_id'    => $value,
                ];
            }

            $sampleIds = $faker->randomElements($prefectureIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobPrefectures[] = [
                    'job_id'        => $jobId,
                    'prefecture_id' => $value,
                ];
            }

            $sampleIds = $faker->randomElements($lineStationIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobRoutes[] = [
                    'job_id'            => $jobId,
                    'line_station_id'   => $value,
                ];
            }

            $sampleIds = $faker->randomElements($salaryIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobSalaries[] = [
                    'job_id'    => $jobId,
                    'salary_id' => $value,
                ];
            }

            $sampleIds = $faker->randomElements($wardIds, rand(2, 5));
            foreach ($sampleIds as $key => $value) {
                $jobWards[] = [
                    'job_id'    => $jobId,
                    'ward_id'   => $value,
                ];
            }

            $sampleIds = $faker->randomElements($workingDayIds, rand(2, min(5, count($workingDayIds))));
            foreach ($sampleIds as $key => $value) {
                $jobWorkingDays[] = [
                    'job_id'            => $jobId,
                    'working_day_id'    => $value,
                ];
            }

            $sampleIds = $faker->randomElements($workingHourIds, rand(2, min(5, count($workingHourIds))));
            foreach ($sampleIds as $key => $value) {
                $jobWorkingHours[] = [
                    'job_id'            => $jobId,
                    'working_hour_id'   => $value,
                ];
            }

            $sampleIds = $faker->randomElements($workingPeriodIds, rand(2, min(5, count($workingPeriodIds))));
            foreach ($sampleIds as $key => $value) {
                $jobWorkingPeriods[] = [
                    'job_id'            => $jobId,
                    'working_period_id' => $value,
                ];
            }

            $sampleIds = $faker->randomElements($workingShiftIds, rand(2, min(5, count($workingShiftIds))));
            foreach ($sampleIds as $key => $value) {
                $jobWorkingShifts[] = [
                    'job_id'            => $jobId,
                    'working_shift_id'  => $value,
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

        printf("    Inserting job_category_level3...\n");
        foreach (array_chunk($jobCat2s, 500) as $data){
            DB::table("job_category_level3")->insert($data);
        }

        printf("    Inserting job_current_situation...\n");
        foreach (array_chunk($jobSituations, 500) as $data){
            DB::table("job_current_situation")->insert($data);
        }

        printf("    Inserting job_employment_mode...\n");
        foreach (array_chunk($jobEmploymentModes, 500) as $data){
            DB::table("job_employment_mode")->insert($data);
        }

        printf("    Inserting job_merit...\n");
        foreach (array_chunk($jobMerits, 500) as $data){
            DB::table("job_merit")->insert($data);
        }

        printf("    Inserting job_prefecture...\n");
        foreach (array_chunk($jobPrefectures, 500) as $data){
            DB::table("job_prefecture")->insert($data);
        }

        printf("    Inserting job_routes...\n");
        foreach (array_chunk($jobRoutes, 500) as $data){
            DB::table("job_routes")->insert($data);
        }

        printf("    Inserting job_salary...\n");
        foreach (array_chunk($jobSalaries, 500) as $data){
            DB::table("job_salary")->insert($data);
        }

        printf("    Inserting job_ward...\n");
        foreach (array_chunk($jobWards, 500) as $data){
            DB::table("job_ward")->insert($data);
        }

        printf("    Inserting job_working_shift...\n");
        foreach (array_chunk($jobWorkingShifts, 500) as $data){
            DB::table("job_working_shift")->insert($data);
        }

        printf("    Inserting job_working_day...\n");
        foreach (array_chunk($jobWorkingDays, 500) as $data){
            DB::table("job_working_day")->insert($data);
        }

        printf("    Inserting job_working_hour...\n");
        foreach (array_chunk($jobWorkingHours, 500) as $data){
            DB::table("job_working_hour")->insert($data);
        }

        printf("    Inserting job_working_period...\n");
        foreach (array_chunk($jobWorkingPeriods, 500) as $data){
            DB::table("job_working_period")->insert($data);
        }
    }
}

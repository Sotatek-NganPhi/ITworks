<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

use App\Models\Job;
use App\Models\Region;

class SpecialPromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specials = [];
        $specialRegions = [];
        $specialJobs = [];
        $faker = Faker::create();
        $regionIds = Region::getAll()->pluck('id');
        $jobIds = range(1, Job::count());
        $RECORD_COUNT = 20;
        $LINKING_PROB = 40;

        for ($specialId = 1; $specialId <= $RECORD_COUNT; $specialId++) {
            $specials[] = [
                'id'            => $specialId,
                'name'          => $faker->sentence,
                'platform'      => rand(1, 3),
                'image'      => $faker->imageUrl(700,150),
                'image_pc'      => $faker->imageUrl(700,150),
                'image_mobile'  => $faker->imageUrl(700,150),
                'start_date'    => $faker->dateTime(),
                'end_date'      => $faker->dateTimeBetween('now', '+5 years'),
                'created_at'    => $faker->dateTime(),
                'updated_at'    => $faker->dateTime(),
            ];

            foreach ($regionIds as $key => $regionId) {
                if (rand(0, 100) > $LINKING_PROB) {
                    continue;
                }

                $specialRegions[] = [
                    'special_promotion_id'  => $specialId,
                    'region_id'             => $regionId,
                ];
            }

            $sampleJobIds = $faker->randomElements($jobIds, rand(2, min(5, count($jobIds))));
            foreach ($sampleJobIds as $key => $jobId) {
                $specialJobs[] = [
                    'job_id'                => $jobId,
                    'special_promotion_id'  => $specialId,
                ];
            }
        }

        foreach (array_chunk($specials, 500) as $data) {
            DB::table('special_promotions')->insert($data);
        }

        foreach (array_chunk($specialRegions, 500) as $data) {
            DB::table('special_promotion_region')->insert($data);
        }

        foreach (array_chunk($specialJobs, 500) as $data) {
            DB::table('job_special')->insert($data);
        }
    }
}

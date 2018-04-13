<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

use App\Models\Merit;
use App\Models\CategoryLevel2;

class PickupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pickups = [];
        $pickupMerits = [];
        $pickupCats = [];
        $faker = Faker::create();
        $meritIds = Merit::getAll()->pluck('id');
        $catIds = CategoryLevel2::getAll()->pluck('id')->toArray();
        $RECORD_COUNT = 20;
        $LINKING_PROB = 40;

        for ($pickupId = 1; $pickupId <= $RECORD_COUNT; $pickupId++) {
            $pickups[] = [
                'id'                => $pickupId,
                'match_condition'   => rand(1, 2),
                'title'             => $faker->sentence,
                'description'       => $faker->paragraph(),
                'image'          => $faker->imageUrl(),
                'image_pc'          => $faker->imageUrl(),
                'image_mobile'      => $faker->imageUrl()
            ];

            if (rand(0, 100) < 50) {
                foreach ($meritIds as $meritId) {
                    if (rand(0, 100) > $LINKING_PROB) {
                        continue;
                    }

                    $pickupMerits[] = [
                        'pickup_id' => $pickupId,
                        'merit_id'  => $meritId,
                    ];
                }
            } else {
                $pickupCats[] = [
                    'pickup_id'          => $pickupId,
                    'category_level3_id' => $faker->randomElement($catIds)
                ];
            }
        }

        foreach (array_chunk($pickups, 500) as $data) {
            DB::table('pickups')->insert($data);
        }

        foreach (array_chunk($pickupMerits, 500) as $data) {
            DB::table('pickup_merit')->insert($data);
        }

        foreach (array_chunk($pickupCats, 500) as $data) {
            DB::table('pickup_category_level3')->insert($data);
        }
    }
}

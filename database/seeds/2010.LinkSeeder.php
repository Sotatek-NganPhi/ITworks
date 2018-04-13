<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Region;
class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [];
        $linkRegions = [];
        $faker = Faker::create();
        $regionIds = Region::getAll()->pluck('id');
        $RECORD_COUNT = 20;
        $LINKING_PROB = 40;
        for ($linkId = 1; $linkId <= $RECORD_COUNT; $linkId++) {
            $links[] = [
                'id'            => $linkId,
                'link_title'    => $faker->sentence,
                'url'           => $faker->url,
                'url_pc'        => $faker->url,
                'url_mobile'    => $faker->url,
                'order_by'      => rand(1, 100),
                'image'         => $faker->imageUrl(250, 54),
                'image_pc'      => $faker->imageUrl(250, 54),
                'image_mobile'  => $faker->imageUrl(250, 54),
                'start_date'    => $faker->dateTime(),
                'end_date'      => $faker->dateTimeBetween('now', '+5 years'),
                'created_at'    => $faker->dateTime(),
                'updated_at'    => $faker->dateTime(),
            ];
            foreach ($regionIds as $regionId) {
                if (rand(0, 100) > $LINKING_PROB) {
                    continue;
                }
                $linkRegions[] = [
                    'link_id'   => $linkId,
                    'region_id' => $regionId,
                ];
            }
        }
        foreach (array_chunk($links, 500) as $data) {
            DB::table('links')->insert($data);
        }
        foreach (array_chunk($linkRegions, 500) as $data) {
            DB::table('link_region')->insert($data);
        }
    }
}
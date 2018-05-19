<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

use App\Models\Region;

class AnnouncementsSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
    $faker = Faker::create();
    DB::table('announcements')->truncate();

    for ($announceId = 1; $announceId <= 30; $announceId++)
    {
        DB::table('announcements')->insert([
            'content' => $faker->paragraph,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addWeeks(4)
            ]);
        $rand=rand(0,4);
        for($i=1;$i<$rand;$i++)
        {
            DB::beginTransaction();
            try {
                DB::table('announcement_region')->insert([
                    'announcement_id' => $announceId,
                    'region_id' => rand(1, 8)
                    ]);
                DB::commit();
            }catch (Exception $e) {
                DB::rollBack();
            }
        }

    }
}
}

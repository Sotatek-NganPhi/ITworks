<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Expo;
use App\Models\Reservation;

class ExposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expos')->truncate();
        DB::table('expo_region')->truncate();
        DB::table('expo_reservations')->truncate();

        for ($i=0; $i < 10; $i++) {
            $this->seedOneExpo();
        }
    }

    private function seedOneExpo() {
        $faker = Faker::create();
        $expo = Expo::create([
                'date' => $faker->dateTimeBetween('+1 week', '+1 month'),
                'organizer_name' => $faker->company(),
                'time' => $faker->dateTime(),
                'start_date' => $faker->dateTimeBetween('-5 years', 'now'),
                'end_date' => $faker->dateTimeBetween('now', '+5 years'),
                'presentation_name' => $faker->sentence(),
                'address' => $faker->address(),
                'content' => $faker->text(),
                'pr' => $faker->text(),
                'map_url' => $faker->url(),
                'cs_email' => $faker->safeEmail(),
                'cs_phone' => $faker->phoneNumber(),
            ]);
        $this->seedReservation($expo->id);
        $this->seedRegion($expo->id);
    }

    private function seedReservation($expoId) {
        $faker = Faker::create();
        $count = rand(1, 10);
        for ($i=0; $i < $count; $i++) {
            $surname = $faker->lastName();
            $name = $faker->firstName();
            Reservation::create([
                'expo_id' => $expoId,
                'surname' => $surname,
                'name' => $name,
                'full_name' => $surname . " " . $name,
                'surname_phonetic' => $surname,
                'name_phonetic' => $name,
                'full_name_phonetic' => $surname . " " . $name,
                'gender' => rand(0, 1),
                'email' => $faker->safeEmail(),
                'current_situation_id' => rand(1, 10),
                'phone_number' => $faker->phoneNumber(),
                'agreed_to_policy' => rand(0, 1)
                ]);
        }
    }

    private function seedRegion($expoId) {
        $regions = [];
        $count = rand(1, 3);
        $existedIds = [];
        for ($i=0; $i < $count; $i++) {
            $regionId = rand(1, 7);
            if (!in_array($regionId, $existedIds)) {
                $regions[] = [
                    'expo_id' => $expoId,
                    'region_id' => $regionId,
                ];
                $existedIds[] = $regionId;
            }
        }
        DB::table('expo_region')->insert($regions);
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->truncate();
        DB::table('managers')->insert([
            [
                'type' => 1,
                'username' => 'admin',
                'name' => 'Super Admin',
                'password' => bcrypt('123'),
                'email' => 'admin@gmail.com'
            ]
        ]);
    }
}

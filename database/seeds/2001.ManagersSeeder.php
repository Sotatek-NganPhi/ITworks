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
            ],
            [
                'type' => 2,
                'username' => 'company',
                'name' => 'Super Company',
                'password' => bcrypt('123'),
                'email' => 'company@gmail.com'
            ]
        ]);
        $companyManager = array();
        for ($i = 1; $i <= 5; $i++) {
            array_push($companyManager, ['company_id' => $i, 'manager_id' => 2]);
        }
        DB::table('company_manager')->insert($companyManager);
    }
}

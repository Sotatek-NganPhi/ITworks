<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User data
        $this->call(ManagersSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(JobsSeeder::class);
        $this->call(ApplicantSeeder::class);
    }
}

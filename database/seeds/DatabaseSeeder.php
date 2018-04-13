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
        $this->call(LinkSeeder::class);
        $this->call(ExposSeeder::class);
        $this->call(PickupsSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(AnnouncementsSeeder::class);
        $this->call(SpecialPromotionSeeder::class);
        $this->call(ApplicantSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(CategoryInterviewSeeder::class);
    }
}

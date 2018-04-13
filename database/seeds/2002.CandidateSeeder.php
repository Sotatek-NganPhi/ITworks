<?php

use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 'normal', 10)->create();
        $candidates = factory(App\Models\Candidate::class, 10)->make();
        foreach ($candidates as $candidate) {
            $candidate->user_id = $users->pop()->id;
            $candidate->save();
        }
    }
}

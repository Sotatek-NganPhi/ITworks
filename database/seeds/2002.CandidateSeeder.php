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
        DB::table('users')->insert([
            [               
                'name' => 'Kim Ngan',
                'email' => 'kimngan.bk.1995@gmail.com',
                'password' => bcrypt('123456'),
                'first_name' => 'Kim',
                'last_name' => 'Ngan',
                'address' => 'Ha Noi',
                'phone_number' => '012345678',
                'gender' => 'female',
                'birthday' => Carbon\Carbon::now(),
                'confirmed' => 1,
                'confirmation_code' => NULL,
            ]
        ]);
        $users = factory(App\User::class, 'normal', 10)->create();
        $candidates = factory(App\Models\Candidate::class, 10)->make();
        foreach ($candidates as $candidate) {
            $candidate->user_id = $users->pop()->id;
            $candidate->save();
        }
    }
}

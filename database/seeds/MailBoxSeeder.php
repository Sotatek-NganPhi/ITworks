<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MailBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailbox = factory(App\Models\Message::class, 100)->make();
        foreach ($mailbox as $mail) {
            $mail->user_id = 1;
            $mail->save();
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class CategoryInterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_interviews')->truncate();
        $data = [['title' => 'Công ty phỏng vấn'], ['title' => 'Công ty phỏng vấn']];
        foreach ($data as $value) {
            DB::table('category_interviews')->insert($value);
        }
    }
}

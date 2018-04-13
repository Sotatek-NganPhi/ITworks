<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder as Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $videos = ['5Qa6Flvv11w', 'Uij-45d4wIs', 'kHzF_4gW78g', 'mA3HYC7tqFA', 'uBGECC5U09Q', 'xzILUpaTtbc',
            'XQkYBbM9YyM', '4S6LqXn56s0', 'aAEQt7wq44w', 'qJdMjRHRLfg', 'aQZDyyIyQMA', 'KxJdMhfn9g4', 'aP_-P_BS6KY',
            'tG35R8F2j8k', 'ayLiAVJ6vTM', 'scIizw2asro', 'Lf6gl4-MPd0', 'qpX2XZBShPc', 's4Y4yUq32gw'];
        $faker = Faker::create('ja_JP');
        $data = [];
        $regionVideos = [];
        for($i = 0; $i < count($videos); $i ++) {
            $data[] = [
                'name' => $faker->name(),
                'description' => $faker->text(),
                'url' => "https://www.youtube.com/embed/" . $videos[$i],
                'thumbnail' => "https://img.youtube.com/vi/" . $videos[$i] . "/hqdefault.jpg",
                'is_active' => 1,
            ];
            $regionVideos = $this->generateRegionVideoData($regionVideos,$i+1);
        }
        DB::table('videos')->insert($data);
        DB::table('region_video')->insert(($regionVideos));
    }
    public function generateRegionVideoData($regionVideos, $id)
    {
        $linkNumber = rand(1, 3);
        $regions = [1,2,3,4,5,6];
        for ($i = 0; $i < $linkNumber; $i++) {
            shuffle($regions);
            $regionVideos[] = [
                'region_id' => array_pop($regions),
                'video_id' => $id
            ];
        }
        return $regionVideos;
    }
}
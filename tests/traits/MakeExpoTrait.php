<?php

use Faker\Factory as Faker;
use App\Models\Expo;
use App\Repositories\ExpoRepository;

trait MakeExpoTrait
{
    /**
     * Create fake instance of Expo and save it in database
     *
     * @param array $expoFields
     * @return Expo
     */
    public function makeExpo($expoFields = [])
    {
        /** @var ExpoRepository $expoRepo */
        $expoRepo = App::make(ExpoRepository::class);
        $theme = $this->fakeExpoData($expoFields);
        return $expoRepo->create($theme);
    }

    /**
     * Get fake instance of Expo
     *
     * @param array $expoFields
     * @return Expo
     */
    public function fakeExpo($expoFields = [])
    {
        return new Expo($this->fakeExpoData($expoFields));
    }

    /**
     * Get fake data of Expo
     *
     * @param array $postFields
     * @return array
     */
    public function fakeExpoData($expoFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'date' => $fake->date('Y-m-d H:i:s'),
            'organizer_name' => $fake->word,
            'time' => $fake->word,
            'start_date' => $fake->date('Y-m-d H:i:s'),
            'end_date' => $fake->date('Y-m-d H:i:s'),
            'presentation_name' => $fake->word,
            'address' => $fake->text,
            'content' => $fake->text,
            'pr' => $fake->text,
            'map_url' => $fake->text,
            'cs_email' => $fake->word,
            'cs_phone' => $fake->text,
            'is_active' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $expoFields);
    }
}

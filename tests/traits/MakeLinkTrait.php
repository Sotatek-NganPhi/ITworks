<?php

use Faker\Factory as Faker;
use App\Models\Link;
use App\Repositories\LinkRepository;

trait MakeLinkTrait
{
    /**
     * Create fake instance of Link and save it in database
     *
     * @param array $linkFields
     * @return Link
     */
    public function makeLink($linkFields = [])
    {
        /** @var LinkRepository $linkRepo */
        $linkRepo = App::make(LinkRepository::class);
        $theme = $this->fakeLinkData($linkFields);
        return $linkRepo->create($theme);
    }

    /**
     * Get fake instance of Link
     *
     * @param array $linkFields
     * @return Link
     */
    public function fakeLink($linkFields = [])
    {
        return new Link($this->fakeLinkData($linkFields));
    }

    /**
     * Get fake data of Link
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLinkData($linkFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'url_pc' => $fake->word,
            'url_mobile' => $fake->word,
            'image_pc' => $fake->word,
            'image_mobile' => $fake->word,
            'start_date' => $fake->date('Y-m-d H:i:s'),
            'end_date' => $fake->date('Y-m-d H:i:s'),
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $linkFields);
    }
}

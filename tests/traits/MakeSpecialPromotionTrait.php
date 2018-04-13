<?php

use Faker\Factory as Faker;
use App\Models\SpecialPromotion;
use App\Repositories\SpecialPromotionRepository;

trait MakeSpecialPromotionTrait
{
    /**
     * Create fake instance of SpecialPromotion and save it in database
     *
     * @param array $specialPromotionFields
     * @return SpecialPromotion
     */
    public function makeSpecialPromotion($specialPromotionFields = [])
    {
        /** @var SpecialPromotionRepository $specialPromotionRepo */
        $specialPromotionRepo = App::make(SpecialPromotionRepository::class);
        $theme = $this->fakeSpecialPromotionData($specialPromotionFields);
        return $specialPromotionRepo->create($theme);
    }

    /**
     * Get fake instance of SpecialPromotion
     *
     * @param array $specialPromotionFields
     * @return SpecialPromotion
     */
    public function fakeSpecialPromotion($specialPromotionFields = [])
    {
        return new SpecialPromotion($this->fakeSpecialPromotionData($specialPromotionFields));
    }

    /**
     * Get fake data of SpecialPromotion
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSpecialPromotionData($specialPromotionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'platform' => $fake->word,
            'image_pc' => $fake->word,
            'image_mobile' => $fake->word,
            'start_date' => $fake->date('Y-m-d H:i:s'),
            'end_date' => $fake->date('Y-m-d H:i:s'),
            'is_active' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $specialPromotionFields);
    }
}

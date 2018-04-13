<?php

use Faker\Factory as Faker;
use App\Models\SocialProvider;
use App\Repositories\SocialProviderRepository;

trait MakeSocialProviderTrait
{
    /**
     * Create fake instance of SocialProvider and save it in database
     *
     * @param array $socialProviderFields
     * @return SocialProvider
     */
    public function makeSocialProvider($socialProviderFields = [])
    {
        /** @var SocialProviderRepository $socialProviderRepo */
        $socialProviderRepo = App::make(SocialProviderRepository::class);
        $theme = $this->fakeSocialProviderData($socialProviderFields);
        return $socialProviderRepo->create($theme);
    }

    /**
     * Get fake instance of SocialProvider
     *
     * @param array $socialProviderFields
     * @return SocialProvider
     */
    public function fakeSocialProvider($socialProviderFields = [])
    {
        return new SocialProvider($this->fakeSocialProviderData($socialProviderFields));
    }

    /**
     * Get fake data of SocialProvider
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSocialProviderData($socialProviderFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'provider' => $fake->word,
            'provider_id' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $socialProviderFields);
    }
}

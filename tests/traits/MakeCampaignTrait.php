<?php

use Faker\Factory as Faker;
use App\Models\Campaign;
use App\Repositories\CampaignRepository;

trait MakeCampaignTrait
{
    /**
     * Create fake instance of Campaign and save it in database
     *
     * @param array $campaignFields
     * @return Campaign
     */
    public function makeCampaign($campaignFields = [])
    {
        /** @var CampaignRepository $campaignRepo */
        $campaignRepo = App::make(CampaignRepository::class);
        $theme = $this->fakeCampaignData($campaignFields);
        return $campaignRepo->create($theme);
    }

    /**
     * Get fake instance of Campaign
     *
     * @param array $campaignFields
     * @return Campaign
     */
    public function fakeCampaign($campaignFields = [])
    {
        return new Campaign($this->fakeCampaignData($campaignFields));
    }

    /**
     * Get fake data of Campaign
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCampaignData($campaignFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'content' => $fake->text,
            'banner_path' => $fake->word,
            'start_at' => $fake->unixTime(),
            'end_at' => $fake->unixTime(),
            'is_active' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $campaignFields);
    }
}

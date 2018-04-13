<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CampaignApiTest extends TestCase
{
    use MakeCampaignTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCampaign()
    {
        $campaign = $this->fakeCampaignData();
        $this->json('POST', '/api/v1/campaigns', $campaign);

        $this->assertApiResponse($campaign);
    }

    /**
     * @test
     */
    public function testReadCampaign()
    {
        $campaign = $this->makeCampaign();
        $this->json('GET', '/api/v1/campaigns/'.$campaign->id);

        $this->assertApiResponse($campaign->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCampaign()
    {
        $campaign = $this->makeCampaign();
        $editedCampaign = $this->fakeCampaignData();

        $this->json('PUT', '/api/v1/campaigns/'.$campaign->id, $editedCampaign);

        $this->assertApiResponse($editedCampaign);
    }

    /**
     * @test
     */
    public function testDeleteCampaign()
    {
        $campaign = $this->makeCampaign();
        $this->json('DELETE', '/api/v1/campaigns/'.$campaign->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/campaigns/'.$campaign->id);

        $this->assertResponseStatus(404);
    }
}

<?php

use App\Models\Campaign;
use App\Repositories\CampaignRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CampaignRepositoryTest extends TestCase
{
    use MakeCampaignTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CampaignRepository
     */
    protected $campaignRepo;

    public function setUp()
    {
        parent::setUp();
        $this->campaignRepo = App::make(CampaignRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCampaign()
    {
        $campaign = $this->fakeCampaignData();
        $createdCampaign = $this->campaignRepo->create($campaign);
        $createdCampaign = $createdCampaign->toArray();
        $this->assertArrayHasKey('id', $createdCampaign);
        $this->assertNotNull($createdCampaign['id'], 'Created Campaign must have id specified');
        $this->assertNotNull(Campaign::find($createdCampaign['id']), 'Campaign with given id must be in DB');
        $this->assertModelData($campaign, $createdCampaign);
    }

    /**
     * @test read
     */
    public function testReadCampaign()
    {
        $campaign = $this->makeCampaign();
        $dbCampaign = $this->campaignRepo->find($campaign->id);
        $dbCampaign = $dbCampaign->toArray();
        $this->assertModelData($campaign->toArray(), $dbCampaign);
    }

    /**
     * @test update
     */
    public function testUpdateCampaign()
    {
        $campaign = $this->makeCampaign();
        $fakeCampaign = $this->fakeCampaignData();
        $updatedCampaign = $this->campaignRepo->update($fakeCampaign, $campaign->id);
        $this->assertModelData($fakeCampaign, $updatedCampaign->toArray());
        $dbCampaign = $this->campaignRepo->find($campaign->id);
        $this->assertModelData($fakeCampaign, $dbCampaign->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCampaign()
    {
        $campaign = $this->makeCampaign();
        $resp = $this->campaignRepo->delete($campaign->id);
        $this->assertTrue($resp);
        $this->assertNull(Campaign::find($campaign->id), 'Campaign should not exist in DB');
    }
}

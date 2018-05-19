<?php

use App\Models\SocialProvider;
use App\Repositories\SocialProviderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocialProviderRepositoryTest extends TestCase
{
    use MakeSocialProviderTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SocialProviderRepository
     */
    protected $socialProviderRepo;

    public function setUp()
    {
        parent::setUp();
        $this->socialProviderRepo = App::make(SocialProviderRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSocialProvider()
    {
        $socialProvider = $this->fakeSocialProviderData();
        $createdSocialProvider = $this->socialProviderRepo->create($socialProvider);
        $createdSocialProvider = $createdSocialProvider->toArray();
        $this->assertArrayHasKey('id', $createdSocialProvider);
        $this->assertNotNull($createdSocialProvider['id'], 'Created SocialProvider must have id specified');
        $this->assertNotNull(SocialProvider::find($createdSocialProvider['id']), 'SocialProvider with given id must be in DB');
        $this->assertModelData($socialProvider, $createdSocialProvider);
    }

    /**
     * @test read
     */
    public function testReadSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $dbSocialProvider = $this->socialProviderRepo->find($socialProvider->id);
        $dbSocialProvider = $dbSocialProvider->toArray();
        $this->assertModelData($socialProvider->toArray(), $dbSocialProvider);
    }

    /**
     * @test update
     */
    public function testUpdateSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $fakeSocialProvider = $this->fakeSocialProviderData();
        $updatedSocialProvider = $this->socialProviderRepo->update($fakeSocialProvider, $socialProvider->id);
        $this->assertModelData($fakeSocialProvider, $updatedSocialProvider->toArray());
        $dbSocialProvider = $this->socialProviderRepo->find($socialProvider->id);
        $this->assertModelData($fakeSocialProvider, $dbSocialProvider->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSocialProvider()
    {
        $socialProvider = $this->makeSocialProvider();
        $resp = $this->socialProviderRepo->delete($socialProvider->id);
        $this->assertTrue($resp);
        $this->assertNull(SocialProvider::find($socialProvider->id), 'SocialProvider should not exist in DB');
    }
}

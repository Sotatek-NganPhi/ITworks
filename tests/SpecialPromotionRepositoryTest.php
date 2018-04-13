<?php

use App\Models\SpecialPromotion;
use App\Repositories\SpecialPromotionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecialPromotionRepositoryTest extends TestCase
{
    use MakeSpecialPromotionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SpecialPromotionRepository
     */
    protected $specialPromotionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->specialPromotionRepo = App::make(SpecialPromotionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSpecialPromotion()
    {
        $specialPromotion = $this->fakeSpecialPromotionData();
        $createdSpecialPromotion = $this->specialPromotionRepo->create($specialPromotion);
        $createdSpecialPromotion = $createdSpecialPromotion->toArray();
        $this->assertArrayHasKey('id', $createdSpecialPromotion);
        $this->assertNotNull($createdSpecialPromotion['id'], 'Created SpecialPromotion must have id specified');
        $this->assertNotNull(SpecialPromotion::find($createdSpecialPromotion['id']), 'SpecialPromotion with given id must be in DB');
        $this->assertModelData($specialPromotion, $createdSpecialPromotion);
    }

    /**
     * @test read
     */
    public function testReadSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $dbSpecialPromotion = $this->specialPromotionRepo->find($specialPromotion->id);
        $dbSpecialPromotion = $dbSpecialPromotion->toArray();
        $this->assertModelData($specialPromotion->toArray(), $dbSpecialPromotion);
    }

    /**
     * @test update
     */
    public function testUpdateSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $fakeSpecialPromotion = $this->fakeSpecialPromotionData();
        $updatedSpecialPromotion = $this->specialPromotionRepo->update($fakeSpecialPromotion, $specialPromotion->id);
        $this->assertModelData($fakeSpecialPromotion, $updatedSpecialPromotion->toArray());
        $dbSpecialPromotion = $this->specialPromotionRepo->find($specialPromotion->id);
        $this->assertModelData($fakeSpecialPromotion, $dbSpecialPromotion->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSpecialPromotion()
    {
        $specialPromotion = $this->makeSpecialPromotion();
        $resp = $this->specialPromotionRepo->delete($specialPromotion->id);
        $this->assertTrue($resp);
        $this->assertNull(SpecialPromotion::find($specialPromotion->id), 'SpecialPromotion should not exist in DB');
    }
}

<?php

use App\Models\MeritGroup;
use App\Repositories\MeritGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeritGroupRepositoryTest extends TestCase
{
    use MakeMeritGroupTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MeritGroupRepository
     */
    protected $meritGroupRepo;

    public function setUp()
    {
        parent::setUp();
        $this->meritGroupRepo = App::make(MeritGroupRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMeritGroup()
    {
        $meritGroup = $this->fakeMeritGroupData();
        $createdMeritGroup = $this->meritGroupRepo->create($meritGroup);
        $createdMeritGroup = $createdMeritGroup->toArray();
        $this->assertArrayHasKey('id', $createdMeritGroup);
        $this->assertNotNull($createdMeritGroup['id'], 'Created MeritGroup must have id specified');
        $this->assertNotNull(MeritGroup::find($createdMeritGroup['id']), 'MeritGroup with given id must be in DB');
        $this->assertModelData($meritGroup, $createdMeritGroup);
    }

    /**
     * @test read
     */
    public function testReadMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $dbMeritGroup = $this->meritGroupRepo->find($meritGroup->id);
        $dbMeritGroup = $dbMeritGroup->toArray();
        $this->assertModelData($meritGroup->toArray(), $dbMeritGroup);
    }

    /**
     * @test update
     */
    public function testUpdateMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $fakeMeritGroup = $this->fakeMeritGroupData();
        $updatedMeritGroup = $this->meritGroupRepo->update($fakeMeritGroup, $meritGroup->id);
        $this->assertModelData($fakeMeritGroup, $updatedMeritGroup->toArray());
        $dbMeritGroup = $this->meritGroupRepo->find($meritGroup->id);
        $this->assertModelData($fakeMeritGroup, $dbMeritGroup->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $resp = $this->meritGroupRepo->delete($meritGroup->id);
        $this->assertTrue($resp);
        $this->assertNull(MeritGroup::find($meritGroup->id), 'MeritGroup should not exist in DB');
    }
}

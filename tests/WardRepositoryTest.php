<?php

use App\Models\Ward;
use App\Repositories\WardRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WardRepositoryTest extends TestCase
{
    use MakeWardTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WardRepository
     */
    protected $wardRepo;

    public function setUp()
    {
        parent::setUp();
        $this->wardRepo = App::make(WardRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWard()
    {
        $ward = $this->fakeWardData();
        $createdWard = $this->wardRepo->create($ward);
        $createdWard = $createdWard->toArray();
        $this->assertArrayHasKey('id', $createdWard);
        $this->assertNotNull($createdWard['id'], 'Created Ward must have id specified');
        $this->assertNotNull(Ward::find($createdWard['id']), 'Ward with given id must be in DB');
        $this->assertModelData($ward, $createdWard);
    }

    /**
     * @test read
     */
    public function testReadWard()
    {
        $ward = $this->makeWard();
        $dbWard = $this->wardRepo->find($ward->id);
        $dbWard = $dbWard->toArray();
        $this->assertModelData($ward->toArray(), $dbWard);
    }

    /**
     * @test update
     */
    public function testUpdateWard()
    {
        $ward = $this->makeWard();
        $fakeWard = $this->fakeWardData();
        $updatedWard = $this->wardRepo->update($fakeWard, $ward->id);
        $this->assertModelData($fakeWard, $updatedWard->toArray());
        $dbWard = $this->wardRepo->find($ward->id);
        $this->assertModelData($fakeWard, $dbWard->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWard()
    {
        $ward = $this->makeWard();
        $resp = $this->wardRepo->delete($ward->id);
        $this->assertTrue($resp);
        $this->assertNull(Ward::find($ward->id), 'Ward should not exist in DB');
    }
}

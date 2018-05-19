<?php

use App\Models\Merit;
use App\Repositories\MeritRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeritRepositoryTest extends TestCase
{
    use MakeMeritTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MeritRepository
     */
    protected $meritRepo;

    public function setUp()
    {
        parent::setUp();
        $this->meritRepo = App::make(MeritRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMerit()
    {
        $merit = $this->fakeMeritData();
        $createdMerit = $this->meritRepo->create($merit);
        $createdMerit = $createdMerit->toArray();
        $this->assertArrayHasKey('id', $createdMerit);
        $this->assertNotNull($createdMerit['id'], 'Created Merit must have id specified');
        $this->assertNotNull(Merit::find($createdMerit['id']), 'Merit with given id must be in DB');
        $this->assertModelData($merit, $createdMerit);
    }

    /**
     * @test read
     */
    public function testReadMerit()
    {
        $merit = $this->makeMerit();
        $dbMerit = $this->meritRepo->find($merit->id);
        $dbMerit = $dbMerit->toArray();
        $this->assertModelData($merit->toArray(), $dbMerit);
    }

    /**
     * @test update
     */
    public function testUpdateMerit()
    {
        $merit = $this->makeMerit();
        $fakeMerit = $this->fakeMeritData();
        $updatedMerit = $this->meritRepo->update($fakeMerit, $merit->id);
        $this->assertModelData($fakeMerit, $updatedMerit->toArray());
        $dbMerit = $this->meritRepo->find($merit->id);
        $this->assertModelData($fakeMerit, $dbMerit->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMerit()
    {
        $merit = $this->makeMerit();
        $resp = $this->meritRepo->delete($merit->id);
        $this->assertTrue($resp);
        $this->assertNull(Merit::find($merit->id), 'Merit should not exist in DB');
    }
}

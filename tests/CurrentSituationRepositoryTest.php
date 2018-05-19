<?php

use App\Models\CurrentSituation;
use App\Repositories\CurrentSituationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CurrentSituationRepositoryTest extends TestCase
{
    use MakeCurrentSituationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CurrentSituationRepository
     */
    protected $currentSituationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->currentSituationRepo = App::make(CurrentSituationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCurrentSituation()
    {
        $currentSituation = $this->fakeCurrentSituationData();
        $createdCurrentSituation = $this->currentSituationRepo->create($currentSituation);
        $createdCurrentSituation = $createdCurrentSituation->toArray();
        $this->assertArrayHasKey('id', $createdCurrentSituation);
        $this->assertNotNull($createdCurrentSituation['id'], 'Created CurrentSituation must have id specified');
        $this->assertNotNull(CurrentSituation::find($createdCurrentSituation['id']), 'CurrentSituation with given id must be in DB');
        $this->assertModelData($currentSituation, $createdCurrentSituation);
    }

    /**
     * @test read
     */
    public function testReadCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $dbCurrentSituation = $this->currentSituationRepo->find($currentSituation->id);
        $dbCurrentSituation = $dbCurrentSituation->toArray();
        $this->assertModelData($currentSituation->toArray(), $dbCurrentSituation);
    }

    /**
     * @test update
     */
    public function testUpdateCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $fakeCurrentSituation = $this->fakeCurrentSituationData();
        $updatedCurrentSituation = $this->currentSituationRepo->update($fakeCurrentSituation, $currentSituation->id);
        $this->assertModelData($fakeCurrentSituation, $updatedCurrentSituation->toArray());
        $dbCurrentSituation = $this->currentSituationRepo->find($currentSituation->id);
        $this->assertModelData($fakeCurrentSituation, $dbCurrentSituation->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCurrentSituation()
    {
        $currentSituation = $this->makeCurrentSituation();
        $resp = $this->currentSituationRepo->delete($currentSituation->id);
        $this->assertTrue($resp);
        $this->assertNull(CurrentSituation::find($currentSituation->id), 'CurrentSituation should not exist in DB');
    }
}

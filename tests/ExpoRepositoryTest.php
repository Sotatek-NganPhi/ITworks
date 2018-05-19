<?php

use App\Models\Expo;
use App\Repositories\ExpoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpoRepositoryTest extends TestCase
{
    use MakeExpoTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExpoRepository
     */
    protected $expoRepo;

    public function setUp()
    {
        parent::setUp();
        $this->expoRepo = App::make(ExpoRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateExpo()
    {
        $expo = $this->fakeExpoData();
        $createdExpo = $this->expoRepo->create($expo);
        $createdExpo = $createdExpo->toArray();
        $this->assertArrayHasKey('id', $createdExpo);
        $this->assertNotNull($createdExpo['id'], 'Created Expo must have id specified');
        $this->assertNotNull(Expo::find($createdExpo['id']), 'Expo with given id must be in DB');
        $this->assertModelData($expo, $createdExpo);
    }

    /**
     * @test read
     */
    public function testReadExpo()
    {
        $expo = $this->makeExpo();
        $dbExpo = $this->expoRepo->find($expo->id);
        $dbExpo = $dbExpo->toArray();
        $this->assertModelData($expo->toArray(), $dbExpo);
    }

    /**
     * @test update
     */
    public function testUpdateExpo()
    {
        $expo = $this->makeExpo();
        $fakeExpo = $this->fakeExpoData();
        $updatedExpo = $this->expoRepo->update($fakeExpo, $expo->id);
        $this->assertModelData($fakeExpo, $updatedExpo->toArray());
        $dbExpo = $this->expoRepo->find($expo->id);
        $this->assertModelData($fakeExpo, $dbExpo->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteExpo()
    {
        $expo = $this->makeExpo();
        $resp = $this->expoRepo->delete($expo->id);
        $this->assertTrue($resp);
        $this->assertNull(Expo::find($expo->id), 'Expo should not exist in DB');
    }
}

<?php

use App\Models\Prefecture;
use App\Repositories\PrefectureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrefectureRepositoryTest extends TestCase
{
    use MakePrefectureTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PrefectureRepository
     */
    protected $prefectureRepo;

    public function setUp()
    {
        parent::setUp();
        $this->prefectureRepo = App::make(PrefectureRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePrefecture()
    {
        $prefecture = $this->fakePrefectureData();
        $createdPrefecture = $this->prefectureRepo->create($prefecture);
        $createdPrefecture = $createdPrefecture->toArray();
        $this->assertArrayHasKey('id', $createdPrefecture);
        $this->assertNotNull($createdPrefecture['id'], 'Created Prefecture must have id specified');
        $this->assertNotNull(Prefecture::find($createdPrefecture['id']), 'Prefecture with given id must be in DB');
        $this->assertModelData($prefecture, $createdPrefecture);
    }

    /**
     * @test read
     */
    public function testReadPrefecture()
    {
        $prefecture = $this->makePrefecture();
        $dbPrefecture = $this->prefectureRepo->find($prefecture->id);
        $dbPrefecture = $dbPrefecture->toArray();
        $this->assertModelData($prefecture->toArray(), $dbPrefecture);
    }

    /**
     * @test update
     */
    public function testUpdatePrefecture()
    {
        $prefecture = $this->makePrefecture();
        $fakePrefecture = $this->fakePrefectureData();
        $updatedPrefecture = $this->prefectureRepo->update($fakePrefecture, $prefecture->id);
        $this->assertModelData($fakePrefecture, $updatedPrefecture->toArray());
        $dbPrefecture = $this->prefectureRepo->find($prefecture->id);
        $this->assertModelData($fakePrefecture, $dbPrefecture->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePrefecture()
    {
        $prefecture = $this->makePrefecture();
        $resp = $this->prefectureRepo->delete($prefecture->id);
        $this->assertTrue($resp);
        $this->assertNull(Prefecture::find($prefecture->id), 'Prefecture should not exist in DB');
    }
}

<?php

use App\Models\Industry;
use App\Repositories\IndustryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndustryRepositoryTest extends TestCase
{
    use MakeIndustryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var IndustryRepository
     */
    protected $industryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->industryRepo = App::make(IndustryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateIndustry()
    {
        $industry = $this->fakeIndustryData();
        $createdIndustry = $this->industryRepo->create($industry);
        $createdIndustry = $createdIndustry->toArray();
        $this->assertArrayHasKey('id', $createdIndustry);
        $this->assertNotNull($createdIndustry['id'], 'Created Industry must have id specified');
        $this->assertNotNull(Industry::find($createdIndustry['id']), 'Industry with given id must be in DB');
        $this->assertModelData($industry, $createdIndustry);
    }

    /**
     * @test read
     */
    public function testReadIndustry()
    {
        $industry = $this->makeIndustry();
        $dbIndustry = $this->industryRepo->find($industry->id);
        $dbIndustry = $dbIndustry->toArray();
        $this->assertModelData($industry->toArray(), $dbIndustry);
    }

    /**
     * @test update
     */
    public function testUpdateIndustry()
    {
        $industry = $this->makeIndustry();
        $fakeIndustry = $this->fakeIndustryData();
        $updatedIndustry = $this->industryRepo->update($fakeIndustry, $industry->id);
        $this->assertModelData($fakeIndustry, $updatedIndustry->toArray());
        $dbIndustry = $this->industryRepo->find($industry->id);
        $this->assertModelData($fakeIndustry, $dbIndustry->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteIndustry()
    {
        $industry = $this->makeIndustry();
        $resp = $this->industryRepo->delete($industry->id);
        $this->assertTrue($resp);
        $this->assertNull(Industry::find($industry->id), 'Industry should not exist in DB');
    }
}

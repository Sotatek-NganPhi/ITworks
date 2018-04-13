<?php

use App\Models\CategoryLevel1;
use App\Repositories\CategoryLevel1Repository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel1RepositoryTest extends TestCase
{
    use MakeCategoryLevel1Trait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryLevel1Repository
     */
    protected $categoryLevel1Repo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryLevel1Repo = App::make(CategoryLevel1Repository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryLevel1()
    {
        $categoryLevel1 = $this->fakeCategoryLevel1Data();
        $createdCategoryLevel1 = $this->categoryLevel1Repo->create($categoryLevel1);
        $createdCategoryLevel1 = $createdCategoryLevel1->toArray();
        $this->assertArrayHasKey('id', $createdCategoryLevel1);
        $this->assertNotNull($createdCategoryLevel1['id'], 'Created CategoryLevel1 must have id specified');
        $this->assertNotNull(CategoryLevel1::find($createdCategoryLevel1['id']), 'CategoryLevel1 with given id must be in DB');
        $this->assertModelData($categoryLevel1, $createdCategoryLevel1);
    }

    /**
     * @test read
     */
    public function testReadCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $dbCategoryLevel1 = $this->categoryLevel1Repo->find($categoryLevel1->id);
        $dbCategoryLevel1 = $dbCategoryLevel1->toArray();
        $this->assertModelData($categoryLevel1->toArray(), $dbCategoryLevel1);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $fakeCategoryLevel1 = $this->fakeCategoryLevel1Data();
        $updatedCategoryLevel1 = $this->categoryLevel1Repo->update($fakeCategoryLevel1, $categoryLevel1->id);
        $this->assertModelData($fakeCategoryLevel1, $updatedCategoryLevel1->toArray());
        $dbCategoryLevel1 = $this->categoryLevel1Repo->find($categoryLevel1->id);
        $this->assertModelData($fakeCategoryLevel1, $dbCategoryLevel1->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $resp = $this->categoryLevel1Repo->delete($categoryLevel1->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryLevel1::find($categoryLevel1->id), 'CategoryLevel1 should not exist in DB');
    }
}

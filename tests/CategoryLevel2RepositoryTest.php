<?php

use App\Models\CategoryLevel2;
use App\Repositories\CategoryLevel2Repository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel2RepositoryTest extends TestCase
{
    use MakeCategoryLevel2Trait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryLevel2Repository
     */
    protected $categoryLevel2Repo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryLevel2Repo = App::make(CategoryLevel2Repository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryLevel2()
    {
        $categoryLevel2 = $this->fakeCategoryLevel2Data();
        $createdCategoryLevel2 = $this->categoryLevel2Repo->create($categoryLevel2);
        $createdCategoryLevel2 = $createdCategoryLevel2->toArray();
        $this->assertArrayHasKey('id', $createdCategoryLevel2);
        $this->assertNotNull($createdCategoryLevel2['id'], 'Created CategoryLevel2 must have id specified');
        $this->assertNotNull(CategoryLevel2::find($createdCategoryLevel2['id']), 'CategoryLevel2 with given id must be in DB');
        $this->assertModelData($categoryLevel2, $createdCategoryLevel2);
    }

    /**
     * @test read
     */
    public function testReadCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $dbCategoryLevel2 = $this->categoryLevel2Repo->find($categoryLevel2->id);
        $dbCategoryLevel2 = $dbCategoryLevel2->toArray();
        $this->assertModelData($categoryLevel2->toArray(), $dbCategoryLevel2);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $fakeCategoryLevel2 = $this->fakeCategoryLevel2Data();
        $updatedCategoryLevel2 = $this->categoryLevel2Repo->update($fakeCategoryLevel2, $categoryLevel2->id);
        $this->assertModelData($fakeCategoryLevel2, $updatedCategoryLevel2->toArray());
        $dbCategoryLevel2 = $this->categoryLevel2Repo->find($categoryLevel2->id);
        $this->assertModelData($fakeCategoryLevel2, $dbCategoryLevel2->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $resp = $this->categoryLevel2Repo->delete($categoryLevel2->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryLevel2::find($categoryLevel2->id), 'CategoryLevel2 should not exist in DB');
    }
}

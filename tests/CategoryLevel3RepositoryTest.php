<?php

use App\Models\CategoryLevel3;
use App\Repositories\CategoryLevel3Repository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel3RepositoryTest extends TestCase
{
    use MakeCategoryLevel3Trait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryLevel3Repository
     */
    protected $categoryLevel3Repo;

    public function setUp()
    {
        parent::setUp();
        $this->categoryLevel3Repo = App::make(CategoryLevel3Repository::class);
    }

    /**
     * @test create
     */
    public function testCreateCategoryLevel3()
    {
        $categoryLevel3 = $this->fakeCategoryLevel3Data();
        $createdCategoryLevel3 = $this->categoryLevel3Repo->create($categoryLevel3);
        $createdCategoryLevel3 = $createdCategoryLevel3->toArray();
        $this->assertArrayHasKey('id', $createdCategoryLevel3);
        $this->assertNotNull($createdCategoryLevel3['id'], 'Created CategoryLevel3 must have id specified');
        $this->assertNotNull(CategoryLevel3::find($createdCategoryLevel3['id']), 'CategoryLevel3 with given id must be in DB');
        $this->assertModelData($categoryLevel3, $createdCategoryLevel3);
    }

    /**
     * @test read
     */
    public function testReadCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $dbCategoryLevel3 = $this->categoryLevel3Repo->find($categoryLevel3->id);
        $dbCategoryLevel3 = $dbCategoryLevel3->toArray();
        $this->assertModelData($categoryLevel3->toArray(), $dbCategoryLevel3);
    }

    /**
     * @test update
     */
    public function testUpdateCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $fakeCategoryLevel3 = $this->fakeCategoryLevel3Data();
        $updatedCategoryLevel3 = $this->categoryLevel3Repo->update($fakeCategoryLevel3, $categoryLevel3->id);
        $this->assertModelData($fakeCategoryLevel3, $updatedCategoryLevel3->toArray());
        $dbCategoryLevel3 = $this->categoryLevel3Repo->find($categoryLevel3->id);
        $this->assertModelData($fakeCategoryLevel3, $dbCategoryLevel3->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $resp = $this->categoryLevel3Repo->delete($categoryLevel3->id);
        $this->assertTrue($resp);
        $this->assertNull(CategoryLevel3::find($categoryLevel3->id), 'CategoryLevel3 should not exist in DB');
    }
}

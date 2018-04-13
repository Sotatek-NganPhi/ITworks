<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel3ApiTest extends TestCase
{
    use MakeCategoryLevel3Trait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryLevel3()
    {
        $categoryLevel3 = $this->fakeCategoryLevel3Data();
        $this->json('POST', '/api/v1/categoryLevel3s', $categoryLevel3);

        $this->assertApiResponse($categoryLevel3);
    }

    /**
     * @test
     */
    public function testReadCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $this->json('GET', '/api/v1/categoryLevel3s/'.$categoryLevel3->id);

        $this->assertApiResponse($categoryLevel3->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $editedCategoryLevel3 = $this->fakeCategoryLevel3Data();

        $this->json('PUT', '/api/v1/categoryLevel3s/'.$categoryLevel3->id, $editedCategoryLevel3);

        $this->assertApiResponse($editedCategoryLevel3);
    }

    /**
     * @test
     */
    public function testDeleteCategoryLevel3()
    {
        $categoryLevel3 = $this->makeCategoryLevel3();
        $this->json('DELETE', '/api/v1/categoryLevel3s/'.$categoryLevel3->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryLevel3s/'.$categoryLevel3->id);

        $this->assertResponseStatus(404);
    }
}

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel2ApiTest extends TestCase
{
    use MakeCategoryLevel2Trait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryLevel2()
    {
        $categoryLevel2 = $this->fakeCategoryLevel2Data();
        $this->json('POST', '/api/v1/categoryLevel2s', $categoryLevel2);

        $this->assertApiResponse($categoryLevel2);
    }

    /**
     * @test
     */
    public function testReadCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $this->json('GET', '/api/v1/categoryLevel2s/'.$categoryLevel2->id);

        $this->assertApiResponse($categoryLevel2->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $editedCategoryLevel2 = $this->fakeCategoryLevel2Data();

        $this->json('PUT', '/api/v1/categoryLevel2s/'.$categoryLevel2->id, $editedCategoryLevel2);

        $this->assertApiResponse($editedCategoryLevel2);
    }

    /**
     * @test
     */
    public function testDeleteCategoryLevel2()
    {
        $categoryLevel2 = $this->makeCategoryLevel2();
        $this->json('DELETE', '/api/v1/categoryLevel2s/'.$categoryLevel2->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryLevel2s/'.$categoryLevel2->id);

        $this->assertResponseStatus(404);
    }
}

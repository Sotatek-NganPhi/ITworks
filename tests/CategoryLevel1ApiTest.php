<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryLevel1ApiTest extends TestCase
{
    use MakeCategoryLevel1Trait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCategoryLevel1()
    {
        $categoryLevel1 = $this->fakeCategoryLevel1Data();
        $this->json('POST', '/api/v1/categoryLevel1s', $categoryLevel1);

        $this->assertApiResponse($categoryLevel1);
    }

    /**
     * @test
     */
    public function testReadCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $this->json('GET', '/api/v1/categoryLevel1s/'.$categoryLevel1->id);

        $this->assertApiResponse($categoryLevel1->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $editedCategoryLevel1 = $this->fakeCategoryLevel1Data();

        $this->json('PUT', '/api/v1/categoryLevel1s/'.$categoryLevel1->id, $editedCategoryLevel1);

        $this->assertApiResponse($editedCategoryLevel1);
    }

    /**
     * @test
     */
    public function testDeleteCategoryLevel1()
    {
        $categoryLevel1 = $this->makeCategoryLevel1();
        $this->json('DELETE', '/api/v1/categoryLevel1s/'.$categoryLevel1->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/categoryLevel1s/'.$categoryLevel1->id);

        $this->assertResponseStatus(404);
    }
}

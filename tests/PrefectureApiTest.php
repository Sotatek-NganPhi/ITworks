<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrefectureApiTest extends TestCase
{
    use MakePrefectureTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePrefecture()
    {
        $prefecture = $this->fakePrefectureData();
        $this->json('POST', '/api/v1/prefectures', $prefecture);

        $this->assertApiResponse($prefecture);
    }

    /**
     * @test
     */
    public function testReadPrefecture()
    {
        $prefecture = $this->makePrefecture();
        $this->json('GET', '/api/v1/prefectures/'.$prefecture->id);

        $this->assertApiResponse($prefecture->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePrefecture()
    {
        $prefecture = $this->makePrefecture();
        $editedPrefecture = $this->fakePrefectureData();

        $this->json('PUT', '/api/v1/prefectures/'.$prefecture->id, $editedPrefecture);

        $this->assertApiResponse($editedPrefecture);
    }

    /**
     * @test
     */
    public function testDeletePrefecture()
    {
        $prefecture = $this->makePrefecture();
        $this->json('DELETE', '/api/v1/prefectures/'.$prefecture->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/prefectures/'.$prefecture->id);

        $this->assertResponseStatus(404);
    }
}

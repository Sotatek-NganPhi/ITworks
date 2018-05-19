<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeritGroupApiTest extends TestCase
{
    use MakeMeritGroupTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMeritGroup()
    {
        $meritGroup = $this->fakeMeritGroupData();
        $this->json('POST', '/api/v1/meritGroups', $meritGroup);

        $this->assertApiResponse($meritGroup);
    }

    /**
     * @test
     */
    public function testReadMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $this->json('GET', '/api/v1/meritGroups/'.$meritGroup->id);

        $this->assertApiResponse($meritGroup->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $editedMeritGroup = $this->fakeMeritGroupData();

        $this->json('PUT', '/api/v1/meritGroups/'.$meritGroup->id, $editedMeritGroup);

        $this->assertApiResponse($editedMeritGroup);
    }

    /**
     * @test
     */
    public function testDeleteMeritGroup()
    {
        $meritGroup = $this->makeMeritGroup();
        $this->json('DELETE', '/api/v1/meritGroups/'.$meritGroup->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/meritGroups/'.$meritGroup->id);

        $this->assertResponseStatus(404);
    }
}

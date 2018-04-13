<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldSettingApiTest extends TestCase
{
    use MakeFieldSettingTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateFieldSetting()
    {
        $fieldSetting = $this->fakeFieldSettingData();
        $this->json('POST', '/api/v1/fieldSettings', $fieldSetting);

        $this->assertApiResponse($fieldSetting);
    }

    /**
     * @test
     */
    public function testReadFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $this->json('GET', '/api/v1/fieldSettings/'.$fieldSetting->id);

        $this->assertApiResponse($fieldSetting->toArray());
    }

    /**
     * @test
     */
    public function testUpdateFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $editedFieldSetting = $this->fakeFieldSettingData();

        $this->json('PUT', '/api/v1/fieldSettings/'.$fieldSetting->id, $editedFieldSetting);

        $this->assertApiResponse($editedFieldSetting);
    }

    /**
     * @test
     */
    public function testDeleteFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $this->json('DELETE', '/api/v1/fieldSettings/'.$fieldSetting->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/fieldSettings/'.$fieldSetting->id);

        $this->assertResponseStatus(404);
    }
}

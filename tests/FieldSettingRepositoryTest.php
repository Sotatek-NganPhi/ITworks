<?php

use App\Models\FieldSetting;
use App\Repositories\FieldSettingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldSettingRepositoryTest extends TestCase
{
    use MakeFieldSettingTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var FieldSettingRepository
     */
    protected $fieldSettingRepo;

    public function setUp()
    {
        parent::setUp();
        $this->fieldSettingRepo = App::make(FieldSettingRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateFieldSetting()
    {
        $fieldSetting = $this->fakeFieldSettingData();
        $createdFieldSetting = $this->fieldSettingRepo->create($fieldSetting);
        $createdFieldSetting = $createdFieldSetting->toArray();
        $this->assertArrayHasKey('id', $createdFieldSetting);
        $this->assertNotNull($createdFieldSetting['id'], 'Created FieldSetting must have id specified');
        $this->assertNotNull(FieldSetting::find($createdFieldSetting['id']), 'FieldSetting with given id must be in DB');
        $this->assertModelData($fieldSetting, $createdFieldSetting);
    }

    /**
     * @test read
     */
    public function testReadFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $dbFieldSetting = $this->fieldSettingRepo->find($fieldSetting->id);
        $dbFieldSetting = $dbFieldSetting->toArray();
        $this->assertModelData($fieldSetting->toArray(), $dbFieldSetting);
    }

    /**
     * @test update
     */
    public function testUpdateFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $fakeFieldSetting = $this->fakeFieldSettingData();
        $updatedFieldSetting = $this->fieldSettingRepo->update($fakeFieldSetting, $fieldSetting->id);
        $this->assertModelData($fakeFieldSetting, $updatedFieldSetting->toArray());
        $dbFieldSetting = $this->fieldSettingRepo->find($fieldSetting->id);
        $this->assertModelData($fakeFieldSetting, $dbFieldSetting->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteFieldSetting()
    {
        $fieldSetting = $this->makeFieldSetting();
        $resp = $this->fieldSettingRepo->delete($fieldSetting->id);
        $this->assertTrue($resp);
        $this->assertNull(FieldSetting::find($fieldSetting->id), 'FieldSetting should not exist in DB');
    }
}

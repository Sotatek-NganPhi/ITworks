<?php

use App\Models\LanguageExperience;
use App\Repositories\LanguageExperienceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageExperienceRepositoryTest extends TestCase
{
    use MakeLanguageExperienceTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LanguageExperienceRepository
     */
    protected $languageExperienceRepo;

    public function setUp()
    {
        parent::setUp();
        $this->languageExperienceRepo = App::make(LanguageExperienceRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLanguageExperience()
    {
        $languageExperience = $this->fakeLanguageExperienceData();
        $createdLanguageExperience = $this->languageExperienceRepo->create($languageExperience);
        $createdLanguageExperience = $createdLanguageExperience->toArray();
        $this->assertArrayHasKey('id', $createdLanguageExperience);
        $this->assertNotNull($createdLanguageExperience['id'], 'Created LanguageExperience must have id specified');
        $this->assertNotNull(LanguageExperience::find($createdLanguageExperience['id']), 'LanguageExperience with given id must be in DB');
        $this->assertModelData($languageExperience, $createdLanguageExperience);
    }

    /**
     * @test read
     */
    public function testReadLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $dbLanguageExperience = $this->languageExperienceRepo->find($languageExperience->id);
        $dbLanguageExperience = $dbLanguageExperience->toArray();
        $this->assertModelData($languageExperience->toArray(), $dbLanguageExperience);
    }

    /**
     * @test update
     */
    public function testUpdateLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $fakeLanguageExperience = $this->fakeLanguageExperienceData();
        $updatedLanguageExperience = $this->languageExperienceRepo->update($fakeLanguageExperience, $languageExperience->id);
        $this->assertModelData($fakeLanguageExperience, $updatedLanguageExperience->toArray());
        $dbLanguageExperience = $this->languageExperienceRepo->find($languageExperience->id);
        $this->assertModelData($fakeLanguageExperience, $dbLanguageExperience->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLanguageExperience()
    {
        $languageExperience = $this->makeLanguageExperience();
        $resp = $this->languageExperienceRepo->delete($languageExperience->id);
        $this->assertTrue($resp);
        $this->assertNull(LanguageExperience::find($languageExperience->id), 'LanguageExperience should not exist in DB');
    }
}

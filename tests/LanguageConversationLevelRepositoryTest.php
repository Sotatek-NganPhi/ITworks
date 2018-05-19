<?php

use App\Models\LanguageConversationLevel;
use App\Repositories\LanguageConversationLevelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageConversationLevelRepositoryTest extends TestCase
{
    use MakeLanguageConversationLevelTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LanguageConversationLevelRepository
     */
    protected $languageConversationLevelRepo;

    public function setUp()
    {
        parent::setUp();
        $this->languageConversationLevelRepo = App::make(LanguageConversationLevelRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLanguageConversationLevel()
    {
        $languageConversationLevel = $this->fakeLanguageConversationLevelData();
        $createdLanguageConversationLevel = $this->languageConversationLevelRepo->create($languageConversationLevel);
        $createdLanguageConversationLevel = $createdLanguageConversationLevel->toArray();
        $this->assertArrayHasKey('id', $createdLanguageConversationLevel);
        $this->assertNotNull($createdLanguageConversationLevel['id'], 'Created LanguageConversationLevel must have id specified');
        $this->assertNotNull(LanguageConversationLevel::find($createdLanguageConversationLevel['id']), 'LanguageConversationLevel with given id must be in DB');
        $this->assertModelData($languageConversationLevel, $createdLanguageConversationLevel);
    }

    /**
     * @test read
     */
    public function testReadLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $dbLanguageConversationLevel = $this->languageConversationLevelRepo->find($languageConversationLevel->id);
        $dbLanguageConversationLevel = $dbLanguageConversationLevel->toArray();
        $this->assertModelData($languageConversationLevel->toArray(), $dbLanguageConversationLevel);
    }

    /**
     * @test update
     */
    public function testUpdateLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $fakeLanguageConversationLevel = $this->fakeLanguageConversationLevelData();
        $updatedLanguageConversationLevel = $this->languageConversationLevelRepo->update($fakeLanguageConversationLevel, $languageConversationLevel->id);
        $this->assertModelData($fakeLanguageConversationLevel, $updatedLanguageConversationLevel->toArray());
        $dbLanguageConversationLevel = $this->languageConversationLevelRepo->find($languageConversationLevel->id);
        $this->assertModelData($fakeLanguageConversationLevel, $dbLanguageConversationLevel->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLanguageConversationLevel()
    {
        $languageConversationLevel = $this->makeLanguageConversationLevel();
        $resp = $this->languageConversationLevelRepo->delete($languageConversationLevel->id);
        $this->assertTrue($resp);
        $this->assertNull(LanguageConversationLevel::find($languageConversationLevel->id), 'LanguageConversationLevel should not exist in DB');
    }
}

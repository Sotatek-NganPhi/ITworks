<?php

use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LinkRepositoryTest extends TestCase
{
    use MakeLinkTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LinkRepository
     */
    protected $linkRepo;

    public function setUp()
    {
        parent::setUp();
        $this->linkRepo = App::make(LinkRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLink()
    {
        $link = $this->fakeLinkData();
        $createdLink = $this->linkRepo->create($link);
        $createdLink = $createdLink->toArray();
        $this->assertArrayHasKey('id', $createdLink);
        $this->assertNotNull($createdLink['id'], 'Created Link must have id specified');
        $this->assertNotNull(Link::find($createdLink['id']), 'Link with given id must be in DB');
        $this->assertModelData($link, $createdLink);
    }

    /**
     * @test read
     */
    public function testReadLink()
    {
        $link = $this->makeLink();
        $dbLink = $this->linkRepo->find($link->id);
        $dbLink = $dbLink->toArray();
        $this->assertModelData($link->toArray(), $dbLink);
    }

    /**
     * @test update
     */
    public function testUpdateLink()
    {
        $link = $this->makeLink();
        $fakeLink = $this->fakeLinkData();
        $updatedLink = $this->linkRepo->update($fakeLink, $link->id);
        $this->assertModelData($fakeLink, $updatedLink->toArray());
        $dbLink = $this->linkRepo->find($link->id);
        $this->assertModelData($fakeLink, $dbLink->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLink()
    {
        $link = $this->makeLink();
        $resp = $this->linkRepo->delete($link->id);
        $this->assertTrue($resp);
        $this->assertNull(Link::find($link->id), 'Link should not exist in DB');
    }
}

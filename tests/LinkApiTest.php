<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LinkApiTest extends TestCase
{
    use MakeLinkTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLink()
    {
        $link = $this->fakeLinkData();
        $this->json('POST', '/api/v1/links', $link);

        $this->assertApiResponse($link);
    }

    /**
     * @test
     */
    public function testReadLink()
    {
        $link = $this->makeLink();
        $this->json('GET', '/api/v1/links/'.$link->id);

        $this->assertApiResponse($link->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLink()
    {
        $link = $this->makeLink();
        $editedLink = $this->fakeLinkData();

        $this->json('PUT', '/api/v1/links/'.$link->id, $editedLink);

        $this->assertApiResponse($editedLink);
    }

    /**
     * @test
     */
    public function testDeleteLink()
    {
        $link = $this->makeLink();
        $this->json('DELETE', '/api/v1/links/'.$link->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/links/'.$link->id);

        $this->assertResponseStatus(404);
    }
}

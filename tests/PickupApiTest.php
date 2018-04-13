<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PickupApiTest extends TestCase
{
    use MakePickupTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePickup()
    {
        $pickup = $this->fakePickupData();
        $this->json('POST', '/api/v1/pickups', $pickup);

        $this->assertApiResponse($pickup);
    }

    /**
     * @test
     */
    public function testReadPickup()
    {
        $pickup = $this->makePickup();
        $this->json('GET', '/api/v1/pickups/'.$pickup->id);

        $this->assertApiResponse($pickup->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePickup()
    {
        $pickup = $this->makePickup();
        $editedPickup = $this->fakePickupData();

        $this->json('PUT', '/api/v1/pickups/'.$pickup->id, $editedPickup);

        $this->assertApiResponse($editedPickup);
    }

    /**
     * @test
     */
    public function testDeletePickup()
    {
        $pickup = $this->makePickup();
        $this->json('DELETE', '/api/v1/pickups/'.$pickup->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/pickups/'.$pickup->id);

        $this->assertResponseStatus(404);
    }
}

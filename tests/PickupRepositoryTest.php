<?php

use App\Models\Pickup;
use App\Repositories\PickupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PickupRepositoryTest extends TestCase
{
    use MakePickupTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PickupRepository
     */
    protected $pickupRepo;

    public function setUp()
    {
        parent::setUp();
        $this->pickupRepo = App::make(PickupRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePickup()
    {
        $pickup = $this->fakePickupData();
        $createdPickup = $this->pickupRepo->create($pickup);
        $createdPickup = $createdPickup->toArray();
        $this->assertArrayHasKey('id', $createdPickup);
        $this->assertNotNull($createdPickup['id'], 'Created Pickup must have id specified');
        $this->assertNotNull(Pickup::find($createdPickup['id']), 'Pickup with given id must be in DB');
        $this->assertModelData($pickup, $createdPickup);
    }

    /**
     * @test read
     */
    public function testReadPickup()
    {
        $pickup = $this->makePickup();
        $dbPickup = $this->pickupRepo->find($pickup->id);
        $dbPickup = $dbPickup->toArray();
        $this->assertModelData($pickup->toArray(), $dbPickup);
    }

    /**
     * @test update
     */
    public function testUpdatePickup()
    {
        $pickup = $this->makePickup();
        $fakePickup = $this->fakePickupData();
        $updatedPickup = $this->pickupRepo->update($fakePickup, $pickup->id);
        $this->assertModelData($fakePickup, $updatedPickup->toArray());
        $dbPickup = $this->pickupRepo->find($pickup->id);
        $this->assertModelData($fakePickup, $dbPickup->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePickup()
    {
        $pickup = $this->makePickup();
        $resp = $this->pickupRepo->delete($pickup->id);
        $this->assertTrue($resp);
        $this->assertNull(Pickup::find($pickup->id), 'Pickup should not exist in DB');
    }
}

<?php

use App\Models\JumpingDate;
use App\Repositories\JumpingDateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JumpingDateRepositoryTest extends TestCase
{
    use MakeJumpingDateTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var JumpingDateRepository
     */
    protected $jumpingDateRepo;

    public function setUp()
    {
        parent::setUp();
        $this->jumpingDateRepo = App::make(JumpingDateRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateJumpingDate()
    {
        $jumpingDate = $this->fakeJumpingDateData();
        $createdJumpingDate = $this->jumpingDateRepo->create($jumpingDate);
        $createdJumpingDate = $createdJumpingDate->toArray();
        $this->assertArrayHasKey('id', $createdJumpingDate);
        $this->assertNotNull($createdJumpingDate['id'], 'Created JumpingDate must have id specified');
        $this->assertNotNull(JumpingDate::find($createdJumpingDate['id']), 'JumpingDate with given id must be in DB');
        $this->assertModelData($jumpingDate, $createdJumpingDate);
    }

    /**
     * @test read
     */
    public function testReadJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $dbJumpingDate = $this->jumpingDateRepo->find($jumpingDate->id);
        $dbJumpingDate = $dbJumpingDate->toArray();
        $this->assertModelData($jumpingDate->toArray(), $dbJumpingDate);
    }

    /**
     * @test update
     */
    public function testUpdateJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $fakeJumpingDate = $this->fakeJumpingDateData();
        $updatedJumpingDate = $this->jumpingDateRepo->update($fakeJumpingDate, $jumpingDate->id);
        $this->assertModelData($fakeJumpingDate, $updatedJumpingDate->toArray());
        $dbJumpingDate = $this->jumpingDateRepo->find($jumpingDate->id);
        $this->assertModelData($fakeJumpingDate, $dbJumpingDate->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteJumpingDate()
    {
        $jumpingDate = $this->makeJumpingDate();
        $resp = $this->jumpingDateRepo->delete($jumpingDate->id);
        $this->assertTrue($resp);
        $this->assertNull(JumpingDate::find($jumpingDate->id), 'JumpingDate should not exist in DB');
    }
}

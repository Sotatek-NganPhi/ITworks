<?php

use App\Models\JumpingCondition;
use App\Repositories\JumpingConditionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JumpingConditionRepositoryTest extends TestCase
{
    use MakeJumpingConditionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var JumpingConditionRepository
     */
    protected $jumpingConditionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->jumpingConditionRepo = App::make(JumpingConditionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateJumpingCondition()
    {
        $jumpingCondition = $this->fakeJumpingConditionData();
        $createdJumpingCondition = $this->jumpingConditionRepo->create($jumpingCondition);
        $createdJumpingCondition = $createdJumpingCondition->toArray();
        $this->assertArrayHasKey('id', $createdJumpingCondition);
        $this->assertNotNull($createdJumpingCondition['id'], 'Created JumpingCondition must have id specified');
        $this->assertNotNull(JumpingCondition::find($createdJumpingCondition['id']), 'JumpingCondition with given id must be in DB');
        $this->assertModelData($jumpingCondition, $createdJumpingCondition);
    }

    /**
     * @test read
     */
    public function testReadJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $dbJumpingCondition = $this->jumpingConditionRepo->find($jumpingCondition->id);
        $dbJumpingCondition = $dbJumpingCondition->toArray();
        $this->assertModelData($jumpingCondition->toArray(), $dbJumpingCondition);
    }

    /**
     * @test update
     */
    public function testUpdateJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $fakeJumpingCondition = $this->fakeJumpingConditionData();
        $updatedJumpingCondition = $this->jumpingConditionRepo->update($fakeJumpingCondition, $jumpingCondition->id);
        $this->assertModelData($fakeJumpingCondition, $updatedJumpingCondition->toArray());
        $dbJumpingCondition = $this->jumpingConditionRepo->find($jumpingCondition->id);
        $this->assertModelData($fakeJumpingCondition, $dbJumpingCondition->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $resp = $this->jumpingConditionRepo->delete($jumpingCondition->id);
        $this->assertTrue($resp);
        $this->assertNull(JumpingCondition::find($jumpingCondition->id), 'JumpingCondition should not exist in DB');
    }
}

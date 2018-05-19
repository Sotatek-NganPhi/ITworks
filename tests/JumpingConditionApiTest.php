<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JumpingConditionApiTest extends TestCase
{
    use MakeJumpingConditionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateJumpingCondition()
    {
        $jumpingCondition = $this->fakeJumpingConditionData();
        $this->json('POST', '/api/v1/jumpingConditions', $jumpingCondition);

        $this->assertApiResponse($jumpingCondition);
    }

    /**
     * @test
     */
    public function testReadJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $this->json('GET', '/api/v1/jumpingConditions/'.$jumpingCondition->id);

        $this->assertApiResponse($jumpingCondition->toArray());
    }

    /**
     * @test
     */
    public function testUpdateJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $editedJumpingCondition = $this->fakeJumpingConditionData();

        $this->json('PUT', '/api/v1/jumpingConditions/'.$jumpingCondition->id, $editedJumpingCondition);

        $this->assertApiResponse($editedJumpingCondition);
    }

    /**
     * @test
     */
    public function testDeleteJumpingCondition()
    {
        $jumpingCondition = $this->makeJumpingCondition();
        $this->json('DELETE', '/api/v1/jumpingConditions/'.$jumpingCondition->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/jumpingConditions/'.$jumpingCondition->id);

        $this->assertResponseStatus(404);
    }
}

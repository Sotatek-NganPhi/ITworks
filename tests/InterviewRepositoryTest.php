<?php

use App\Models\Interview;
use App\Repositories\InterviewRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InterviewRepositoryTest extends TestCase
{
    use MakeInterviewTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var InterviewRepository
     */
    protected $interviewRepo;

    public function setUp()
    {
        parent::setUp();
        $this->interviewRepo = App::make(InterviewRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateInterview()
    {
        $interview = $this->fakeInterviewData();
        $createdInterview = $this->interviewRepo->create($interview);
        $createdInterview = $createdInterview->toArray();
        $this->assertArrayHasKey('id', $createdInterview);
        $this->assertNotNull($createdInterview['id'], 'Created Interview must have id specified');
        $this->assertNotNull(Interview::find($createdInterview['id']), 'Interview with given id must be in DB');
        $this->assertModelData($interview, $createdInterview);
    }

    /**
     * @test read
     */
    public function testReadInterview()
    {
        $interview = $this->makeInterview();
        $dbInterview = $this->interviewRepo->find($interview->id);
        $dbInterview = $dbInterview->toArray();
        $this->assertModelData($interview->toArray(), $dbInterview);
    }

    /**
     * @test update
     */
    public function testUpdateInterview()
    {
        $interview = $this->makeInterview();
        $fakeInterview = $this->fakeInterviewData();
        $updatedInterview = $this->interviewRepo->update($fakeInterview, $interview->id);
        $this->assertModelData($fakeInterview, $updatedInterview->toArray());
        $dbInterview = $this->interviewRepo->find($interview->id);
        $this->assertModelData($fakeInterview, $dbInterview->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteInterview()
    {
        $interview = $this->makeInterview();
        $resp = $this->interviewRepo->delete($interview->id);
        $this->assertTrue($resp);
        $this->assertNull(Interview::find($interview->id), 'Interview should not exist in DB');
    }
}

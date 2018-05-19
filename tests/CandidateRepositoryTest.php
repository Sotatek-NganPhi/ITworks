<?php

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CandidateRepositoryTest extends TestCase
{
    use MakeCandidateTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CandidateRepository
     */
    protected $candidateRepo;

    public function setUp()
    {
        parent::setUp();
        $this->candidateRepo = App::make(CandidateRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCandidate()
    {
        $candidate = $this->fakeCandidateData();
        $createdCandidate = $this->candidateRepo->create($candidate);
        $createdCandidate = $createdCandidate->toArray();
        $this->assertArrayHasKey('id', $createdCandidate);
        $this->assertNotNull($createdCandidate['id'], 'Created Candidate must have id specified');
        $this->assertNotNull(Candidate::find($createdCandidate['id']), 'Candidate with given id must be in DB');
        $this->assertModelData($candidate, $createdCandidate);
    }

    /**
     * @test read
     */
    public function testReadCandidate()
    {
        $candidate = $this->makeCandidate();
        $dbCandidate = $this->candidateRepo->find($candidate->id);
        $dbCandidate = $dbCandidate->toArray();
        $this->assertModelData($candidate->toArray(), $dbCandidate);
    }

    /**
     * @test update
     */
    public function testUpdateCandidate()
    {
        $candidate = $this->makeCandidate();
        $fakeCandidate = $this->fakeCandidateData();
        $updatedCandidate = $this->candidateRepo->update($fakeCandidate, $candidate->id);
        $this->assertModelData($fakeCandidate, $updatedCandidate->toArray());
        $dbCandidate = $this->candidateRepo->find($candidate->id);
        $this->assertModelData($fakeCandidate, $dbCandidate->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCandidate()
    {
        $candidate = $this->makeCandidate();
        $resp = $this->candidateRepo->delete($candidate->id);
        $this->assertTrue($resp);
        $this->assertNull(Candidate::find($candidate->id), 'Candidate should not exist in DB');
    }
}

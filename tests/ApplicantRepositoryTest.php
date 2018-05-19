<?php

use App\Models\Applicant;
use App\Repositories\ApplicantRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicantRepositoryTest extends TestCase
{
    use MakeApplicantTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ApplicantRepository
     */
    protected $applicantRepo;

    public function setUp()
    {
        parent::setUp();
        $this->applicantRepo = App::make(ApplicantRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateApplicant()
    {
        $applicant = $this->fakeApplicantData();
        $createdApplicant = $this->applicantRepo->create($applicant);
        $createdApplicant = $createdApplicant->toArray();
        $this->assertArrayHasKey('id', $createdApplicant);
        $this->assertNotNull($createdApplicant['id'], 'Created Applicant must have id specified');
        $this->assertNotNull(Applicant::find($createdApplicant['id']), 'Applicant with given id must be in DB');
        $this->assertModelData($applicant, $createdApplicant);
    }

    /**
     * @test read
     */
    public function testReadApplicant()
    {
        $applicant = $this->makeApplicant();
        $dbApplicant = $this->applicantRepo->find($applicant->id);
        $dbApplicant = $dbApplicant->toArray();
        $this->assertModelData($applicant->toArray(), $dbApplicant);
    }

    /**
     * @test update
     */
    public function testUpdateApplicant()
    {
        $applicant = $this->makeApplicant();
        $fakeApplicant = $this->fakeApplicantData();
        $updatedApplicant = $this->applicantRepo->update($fakeApplicant, $applicant->id);
        $this->assertModelData($fakeApplicant, $updatedApplicant->toArray());
        $dbApplicant = $this->applicantRepo->find($applicant->id);
        $this->assertModelData($fakeApplicant, $dbApplicant->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteApplicant()
    {
        $applicant = $this->makeApplicant();
        $resp = $this->applicantRepo->delete($applicant->id);
        $this->assertTrue($resp);
        $this->assertNull(Applicant::find($applicant->id), 'Applicant should not exist in DB');
    }
}

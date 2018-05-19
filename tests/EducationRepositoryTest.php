<?php

use App\Models\Education;
use App\Repositories\EducationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EducationRepositoryTest extends TestCase
{
    use MakeEducationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var EducationRepository
     */
    protected $educationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->educationRepo = App::make(EducationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateEducation()
    {
        $education = $this->fakeEducationData();
        $createdEducation = $this->educationRepo->create($education);
        $createdEducation = $createdEducation->toArray();
        $this->assertArrayHasKey('id', $createdEducation);
        $this->assertNotNull($createdEducation['id'], 'Created Education must have id specified');
        $this->assertNotNull(Education::find($createdEducation['id']), 'Education with given id must be in DB');
        $this->assertModelData($education, $createdEducation);
    }

    /**
     * @test read
     */
    public function testReadEducation()
    {
        $education = $this->makeEducation();
        $dbEducation = $this->educationRepo->find($education->id);
        $dbEducation = $dbEducation->toArray();
        $this->assertModelData($education->toArray(), $dbEducation);
    }

    /**
     * @test update
     */
    public function testUpdateEducation()
    {
        $education = $this->makeEducation();
        $fakeEducation = $this->fakeEducationData();
        $updatedEducation = $this->educationRepo->update($fakeEducation, $education->id);
        $this->assertModelData($fakeEducation, $updatedEducation->toArray());
        $dbEducation = $this->educationRepo->find($education->id);
        $this->assertModelData($fakeEducation, $dbEducation->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteEducation()
    {
        $education = $this->makeEducation();
        $resp = $this->educationRepo->delete($education->id);
        $this->assertTrue($resp);
        $this->assertNull(Education::find($education->id), 'Education should not exist in DB');
    }
}

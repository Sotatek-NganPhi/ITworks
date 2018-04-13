<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Repositories\Traits\Criteriable;
use InfyOm\Generator\Common\BaseRepository;

class CandidateRepository extends BaseRepository
{
    use Criteriable;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'is_married',
        'final_academic_school',
        'graduated_at',
        'current_situation_id',
        'toeic',
        'toefl',
        'worked_companies_number',
        'lastest_company_name',
        'lastest_annual_income',
        'lastest_job_description',
        'platform_flag',
        'user.birthday',
        'user.gender',
        'user.name' => 'like',
        'user.name_phonetic' => 'like',
        'user.first_name' => 'like',
        'user.last_name' => 'like',
        'user.first_name_phonetic' => 'like',
        'user.last_name_phonetic' => 'like',
        'user.email' => 'like',
        'prefectures.prefecture_id',
        'categoryLevel2s.category_level2_id',
        'categoryLevel3s.category_level3_id',
        'salaries.salary_id',
        'workingShifts.working_shift_id',
        'employmentModes.employment_mode_id',
        'merits.merit_id',
        'reference.referral_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Candidate::class;
    }

    public function joinUsers() {
        $this->model->join('users', 'users.id', 'candidates.user_id');
        return $this;
    }
}

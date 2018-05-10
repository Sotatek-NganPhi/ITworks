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
        'final_academic_school',
        'graduated_at',
        'toeic',
        'toefl',
        'user.birthday',
        'user.gender',
        'user.name' => 'like',
        'user.first_name' => 'like',
        'user.last_name' => 'like',
        'user.email' => 'like',
        'prefectures.prefecture_id',
        'salaries.salary_id',
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

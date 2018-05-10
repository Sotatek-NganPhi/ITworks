<?php

namespace App\Repositories;

use App\Models\Job;
use App\Repositories\Traits\Criteriable;

class JobRepository extends AppBaseRepository
{
    use Criteriable;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'company_id',
        'applicants.COUNT()' => '>=',
        'company_id',
        'applicants_count',
        'prefectures.region_id',
        'original_state',
        'company_name'       => 'like',
        'post_start_date'    => '>=',
        'post_end_date'      => '<=',
        'salary'             => 'like',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Job::class;
    }

    public function getCounter()
    {
        return $this->with(['counters', 'company'])
            ->withCount('applicants');
    }

    public function viewCount()
    {
        $this->model->leftJoin('job_counters', 'jobs.id', 'job_counters.job_id')
            ->selectRaw('sum(views) as views')->groupBy('jobs.id');
        return $this;
    }

    public function rules()
    {
        return [
            'company_id'            => 'required|integer|exists:companies,id',
            'company_name'          => 'required',
            'description'           => 'required',
            'post_start_date'       => 'required|date',
            'post_end_date'         => 'required|date|after:post_start_date',
            'original_state'        => 'required',
            'salary'                => 'required',
            'application_condition' => 'required',
            'categoryLevel3s'       => 'required',
            'prefectures'           => 'required',
            // 'wards'                 => 'required'
        ];
    }
}

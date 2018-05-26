<?php
namespace App\Ranking;

use DB;

use App\Models\Job;
use App\Models\Candidate;
use App\Models\CandidateJobRanking;
use Illuminate\Support\Facades\Log;

class RankingService
{
    const BULK_SIZE = 1000;

    protected $criteria = [
        'prefecture',
    ];


    public function updateCandidates($candidates)
    {
        CandidateJobRanking::whereIn('candidate_id', $candidates->pluck('id'))->delete();
        $this->updateRankings($candidates, Job::all());
    }

    public function updateJobs($jobs)
    {
        CandidateJobRanking::whereIn('job_id', $jobs->pluck('id'))->delete();
        $this->updateRankings(Candidate::all(), $jobs);
    }

    public function deleteJob($jobId)
    {
        $candidates = CandidateJobRanking::where('job_id', $jobId)->delete();
        $bulk = [];


        foreach ($candidates as $candidate) {
            Log::info("Delete ranking of candidate {$candidate->id} and job {$jobId}... \n");

            $ranking = $this->countMatchedCriteria($candidate->id, $jobId);

            $bulk[] = ['candidate_id' => $candidate->id, 'job_id' => $jobId, 'ranking' => $ranking];

            if (count($bulk) >= self::BULK_SIZE) {
                CandidateJobRanking::insert($bulk);
                $bulk = [];
            }
        }
    }

    public function deleteCandidate($candidateId)
    {
        CandidateJobRanking::whereIn('candidate_id', $candidateId)->delete();
        $bulk = [];


        foreach (Job::all() as $job) {
            Log::info("Update ranking of candidate {$candidateId} and job {$job->id}... \n");

            $ranking = $this->countMatchedCriteria($candidateId, $job->id);

            $bulk[] = ['candidate_id' => $candidateId, 'job_id' => $job->id, 'ranking' => $ranking];

            if (count($bulk) >= self::BULK_SIZE) {
                CandidateJobRanking::insert($bulk);
                $bulk = [];
            }
        }
    }

    public function updateOne($model)
    {
        if ($model instanceof Job) {
            $this->updateJobs(collect([$model]));
        }
        if ($model instanceof Candidate) {
            $this->updateCandidates(collect([$model]));
        }
    }

    public function updateAll()
    {
        CandidateJobRanking::truncate();
        $this->updateRankings(Candidate::all(), Job::all());
    }

    public function updateRankings($candidates, $jobs)
    {
        $bulk = [];

        foreach ($candidates as $candidate) {
            foreach ($jobs as $job) {
                Log::info("Update ranking of candidate {$candidate->id} and job {$job->id}... \n");

                $ranking = $this->countMatchedCriteria($candidate->id, $job->id);

                $bulk[] = ['candidate_id' => $candidate->id, 'job_id' => $job->id, 'ranking' => $ranking];

                if (count($bulk) >= self::BULK_SIZE) {
                    CandidateJobRanking::insert($bulk);
                    $bulk = [];
                }
            }
        }
    }

    public function countMatchedCriteria($candidateId, $jobId)
    {
        $total = collect($this->criteria)->reduce(function ($carry, $criterion) use ($candidateId, $jobId) {
            return $carry + min(count($this->matchedCriterion($candidateId, $jobId, $criterion)), 1);
        }, 0);
        return $total;
    }

    public function matchedCriterion($candidateId, $jobId, $criterion)
    {
        return DB::select(DB::raw($this->getQueryString($candidateId, $jobId, $criterion)));
    }

    public function getQueryString($candidateId, $jobId, $criterion)
    {
        return "SELECT * FROM job_${criterion} WHERE {$criterion}_id IN "
            . "(SELECT candidate_${criterion}.${criterion}_id FROM candidates "
            . "INNER JOIN candidate_${criterion} ON candidates.id = candidate_${criterion}.candidate_id "
            . "WHERE candidates.id = ${candidateId}) "
            . "AND job_id = {$jobId}";
    }
}

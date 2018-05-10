<?php

namespace App\Console\Commands;

use DB;
use App\Http\Services\MasterdataService;
use Illuminate\Console\Command;
use App\User;
use App\Models\CandidateJobRanking;
use App\Models\Candidate;
use App\Models\Job;

class ResetRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate the ranking table of jobs and candidates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastCandidate = Candidate::orderBy('updated_at', 'dersc')->first();
        $lastJob = Job::orderBy('updated_at', 'dersc')->first();

        if (!$lastCandidate || !$lastJob) {
            return;
        }

        $lastRanking = CandidateJobRanking::orderBy('updated_at', 'dersc')->first();
        $lastUpdate = min($lastCandidate->updated_at, $lastJob->updated_at);
        if (!$lastRanking || $lastRanking->created_at < $lastUpdate) {
            app('rankingservice')->updateAll();
        }
    }
}

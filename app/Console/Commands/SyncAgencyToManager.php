<?php

namespace App\Console\Commands;

use App\Consts;
use App\Manager;
use App\Models\ReferralAgency;
use Illuminate\Console\Command;

class SyncAgencyToManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync agency to manager';

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
        Manager::where('type', Consts::TYPE_AGENCY_ADMIN)->delete();
        foreach (ReferralAgency::all() as $agency) {
            $agency->sycToManager();
        }
    }
}

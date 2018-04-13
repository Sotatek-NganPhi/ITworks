<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Http\Services\MasterdataService;
use Illuminate\Console\Command;
use App\Mail\AutoMail;
use App\Models\Candidate;
use Illuminate\Support\Facades\Mail;

class AutoSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to users';

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
        $autoMailConfig = MasterdataService::getOneTable('configs')->where('key', 'mail_auto_settings')->first();
        $settings = json_decode($autoMailConfig->value, true);
        $candidates = Candidate::mailable()->with('user')->get();
        $deliveryDate = Carbon::parse($settings['delivery_date']);

        $startAt = Carbon::today();

        if($startAt->diffInDays($deliveryDate, false) < 0) {
            return;
        }

        $startAt->hour = $deliveryDate->hour;
        $startAt->minute = $deliveryDate->minute;
        $startAt->second = $deliveryDate->second;

        foreach ($candidates as $candidate) {
            $jobs = $candidate->jobs()->limit($settings['work'])->get();
            Mail::to($candidate->user->email, $candidate->user->name)->later($startAt, new AutoMail($settings, $jobs));
        }
    }
}

<?php

namespace App\Console;
use App\Http\Services\MasterdataService;
use DateTime;
use Carbon\Carbon;
use App\Console\Commands\UpdateMasterdata;
use App\Console\Commands\ResetRanking;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateMasterdata::class,
        ResetRanking::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('automail')->daily()->when(function () {
    //         return $this->isAutoSendMailTime();
    //     });
    // }

    // public function isAutoSendMailTime()
    // {
    //     $autoMailConfig = MasterdataService::getOneTable('configs')->where('key', 'mail_auto_settings')->first();
    //     $settings = json_decode($autoMailConfig->value, true);
    //     $diffDays = (int)(Carbon::today()->diffInDays(Carbon::parse($settings['delivery_date']), false)->format('%d'));

    //     if(strcmp($settings['status'],'Hợp lệ') == 0){
    //         return $diffDays >= 0 && $diffDays % $settings['interval'] === 0;
    //     }
    //     return false;
    // }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

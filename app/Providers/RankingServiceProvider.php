<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ranking\RankingService;

class RankingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('rankingservice', function () {
            return new RankingService();
        });
    }
}

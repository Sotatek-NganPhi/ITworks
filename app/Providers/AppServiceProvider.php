<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Config;
use App\Models\FieldSetting;
use App\Models\Region;
use App\Models\Prefecture;
use App\Observers\CompanyObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Services\JobService;
use App\Http\Services\MasterdataService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    protected $jobService;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jobService = new JobService();
    }
    public function boot()
    {
        Schema::defaultStringLength(191);

        // TODO: Remove this hack
        View::composer('app.footer', function ($view) {
            $prefectures = Prefecture::getPrefecturesWithRegionKey();
            $view->with('prefectures', $prefectures);
        });

        View::composer('app.header', function ($view) {
            $view->with('regions', Region::getAll());
        });

        View::composer('app.home.lp_business', function ($view) {
            $view->with('regions', Region::getAll());
        });

        View::composer('app.layout', function ($view) {
            $view->with('dataVersion', MasterdataService::getDataVersion());
        });

        View::composer('*', function ($view) {
            $view->with('configs', Config::getConfigByKey());
            $view->with('fieldSettings', FieldSetting::getGroupedData());
            $view->with('dataVersion', MasterdataService::getDataVersion());
        });

        DB::enableQueryLog();
        DB::listen(function ($query) {
            Log::debug('SQL', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'runtime' => $query->time
            ]);
        });

        //register model observer
        Company::observe(CompanyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

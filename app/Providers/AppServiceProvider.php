<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\UserReferral;
use App\Observers\UserReferralObserver;
use App\Models\IncomeHistory;
use App\Observers\IncomeHistoryObserver;
use App\Models\TempUpgradeRequest;
use App\Observers\TempUpgradeRequestObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        UserReferral::observe(UserReferralObserver::class);
        IncomeHistory::observe(IncomeHistoryObserver::class);
        TempUpgradeRequest::observe(TempUpgradeRequestObserver::class);

        /*$this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);*/
    }
}

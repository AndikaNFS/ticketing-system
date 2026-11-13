<?php

namespace App\Providers;

use App\Models\DailyReport;
use App\Policies\DailyReportPolicy;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        DailyReport::class => DailyReportPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FinancialReport;
use App\Policies\FinancialReportPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All the model/policy mappings
     */
    protected $policies = [
        FinancialReport::class => FinancialReportPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

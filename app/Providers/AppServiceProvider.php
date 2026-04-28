<?php

namespace App\Providers;

use App\Repository\BattleRepositoryInterface;
use App\Repository\DatabaseBattleRepository;
use App\Service\BattleServiceInterface;
use App\Service\BattleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind the Repository Interface to its concrete Database implementation
        $this->app->bind(
            BattleRepositoryInterface::class,
            DatabaseBattleRepository::class
        );

        // Bind the Service Interface to its concrete implementation
        $this->app->bind(
            BattleServiceInterface::class,
            BattleService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}

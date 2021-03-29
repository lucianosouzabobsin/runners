<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    RunnerRepositoryInterface,
    CompetitionRepositoryInterface,
    RunnerCompetitionRepositoryInterface
};
use App\Repositories\{
    RunnerRepository,
    CompetitionRepository,
    RunnerCompetitionRepository
};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CompetitionRepositoryInterface::class,
            CompetitionRepository::class
        );

        $this->app->bind(
            RunnerRepositoryInterface::class,
            RunnerRepository::class
        );

        $this->app->bind(
            RunnerCompetitionRepositoryInterface::class,
            RunnerCompetitionRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

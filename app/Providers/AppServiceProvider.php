<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Place\Application\UseCase\CreatePlace\CreatePlaceUseCase;
use Src\Place\Application\UseCase\GetAllPlace\GetAllPlaceUseCase;
use Src\Place\Application\UseCase\GetSpecificPlace\GetSpecificPlaceUseCase;
use Src\Place\Application\UseCase\UpdatePlace\UpdatePlaceUseCase;
use Src\Place\Domain\PlaceGateway;
use Src\Place\Infra\Repository\PgSql\PlaceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreatePlaceUseCase::class, function ($app) {
            return CreatePlaceUseCase::create($app->make(PlaceGateway::class));
        });

        $this->app->singleton(UpdatePlaceUseCase::class, function ($app) {
            return UpdatePlaceUseCase::create($app->make(PlaceGateway::class));
        });

        $this->app->singleton(GetAllPlaceUseCase::class, function ($app) {
            return GetAllPlaceUseCase::create($app->make(PlaceGateway::class));
        });

        $this->app->singleton(GetSpecificPlaceUseCase::class, function ($app) {
            return GetSpecificPlaceUseCase::create($app->make(PlaceGateway::class));
        });

        $this->app->bind(PlaceGateway::class, function () {
            return new PlaceRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

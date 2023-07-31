<?php

namespace App\Providers;

use App\Repositories\Interfaces\APIServiceInterface;
use App\Repositories\Interfaces\ParserInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductImagesRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImagesRepository;
use App\Services\APIService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind your services here
        $this->app->bind(APIService::class, function ($app) {
            return new APIService();
        });

        $this->app->bind(ParserService::class, function ($app) {
            return new ParserService();
        });

        $this->app->bind(MapperService::class, function ($app) {
            return new MapperService();
        });

        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });

        $this->app->bind(ProductImagesRepository::class, function ($app) {
            return new ProductImagesRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

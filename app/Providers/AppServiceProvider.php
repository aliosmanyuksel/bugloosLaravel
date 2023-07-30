<?php

namespace App\Providers;

use App\Repositories\Interfaces\APIServiceInterface;
use App\Repositories\Interfaces\ParserInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductImagesRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImagesRepository;
use App\Services\APIService;
use App\Services\JsonParser;
use App\Services\XmlParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(APIServiceInterface::class, APIService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductImagesRepositoryInterface::class, ProductImagesRepository::class);
        $this->app->bind(ParserInterface::class, function ($app) {
            if ($app['request']->header('Content-Type') === 'application/xml') {
                return new XmlParser;
            }

            return new JsonParser;
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

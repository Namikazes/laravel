<?php

namespace App\Providers;

use App\Repositories\Contracts\ImageRepositoryContract;
use App\Repositories\Contracts\ProductsRepositoryContract;
use App\Repositories\ImageRepository;
use App\Repositories\ProductsRepository;
use App\Services\Contract\FileStorageServicesContract;
use App\Services\FileStorageServices;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        FileStorageServicesContract::class => FileStorageServices::class,
        ProductsRepositoryContract::class => ProductsRepository::class,
        ImageRepositoryContract::class => ImageRepository::class
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
        Paginator::useBootstrapFive();
    }
}

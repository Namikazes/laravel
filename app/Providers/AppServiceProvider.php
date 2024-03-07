<?php

namespace App\Providers;

use App\Repositories\Contracts\ImageRepositoryContract;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\ProductsRepositoryContract;
use App\Repositories\ImageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductsRepository;
use App\Services\Contract\FileStorageServicesContract;
use App\Services\Contract\InvoiceServicesContract;
use App\Services\Contract\PayPalServicesContract;
use App\Services\FileStorageServices;
use App\Services\InvoiceServices;
use App\Services\PayPalServices;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        FileStorageServicesContract::class => FileStorageServices::class,
        ProductsRepositoryContract::class => ProductsRepository::class,
        ImageRepositoryContract::class => ImageRepository::class,
        PayPalServicesContract::class => PayPalServices::class,
        OrderRepositoryContract::class => OrderRepository::class,
        InvoiceServicesContract::class => InvoiceServices::class
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

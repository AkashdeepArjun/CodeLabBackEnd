<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\PolicyProduct;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [Product::class =>PolicyProduct::class];



    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

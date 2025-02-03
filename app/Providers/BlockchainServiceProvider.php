<?php

namespace App\Providers;

use App\Services\Blockchain\BlockchainService;
use App\Services\Blockchain\BlockchainTransactionService;
use App\Services\Blockchain\Implementations\BlockchainImplementation;
use Illuminate\Support\ServiceProvider;

class BlockchainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

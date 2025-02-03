<?php

namespace App\Providers;

use App\Blockchain\BlockchainBridge;
use App\Services\Blockchain\Implementations\BlockchainImplementation;
use Illuminate\Support\ServiceProvider;

class BlockchainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BlockchainBridge::class, function ($app) {
            //$blockchainType = config('blockchain.default'); // Legge la configurazione, in base ad essa con un if si cambia l'implementazione
            return new BlockchainImplementation;
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

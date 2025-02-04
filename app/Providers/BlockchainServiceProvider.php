<?php

namespace App\Providers;

use App\Services\Blockchain\BlockchainBridge;
use App\Services\Blockchain\Implementation\CursaImplementation;
use Illuminate\Support\ServiceProvider;

class BlockchainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //$blockchainType = config('blockchain.default'); // Legge la configurazione, in base ad essa con un if si cambia l'implementazione
        $this->app->bind(BlockchainBridge::class, function($app) {
            return new BlockchainBridge(new CursaImplementation);
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

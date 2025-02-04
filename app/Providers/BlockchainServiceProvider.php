<?php

namespace App\Providers;

use App\Services\Blockchain\BlockchainBridge;
use App\Services\Blockchain\Implementation\CursaImplementation;
use Illuminate\Support\ServiceProvider;

/**
 * In questa classe è possibile cambiare l'implementazione della blockchain a piacimento
 */
class BlockchainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Legge la configurazione, in base ad essa con un if si cambia l'implementazione
        //$blockchainType = config('blockchain.default');
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

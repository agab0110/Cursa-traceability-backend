<?php

namespace App\Services\Blockchain;

/**
 * Interfaccia per implementazione nella blockchain
 */
interface BlockchainInterface {
    public function connect();
    public function getData(string $id);
    public function sendTransaction(array $data);
}

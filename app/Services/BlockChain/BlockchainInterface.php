<?php

namespace App\Services\Blockchain;

interface BlockchainInterface {
    public function connect();
    public function getData(string $id);
    public function sendTransaction(array $data);
}

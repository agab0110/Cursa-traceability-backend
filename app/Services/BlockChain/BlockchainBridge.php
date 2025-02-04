<?php

namespace App\Services\Blockchain;

use App\Services\Blockchain\BlockchainInterface;

class BlockchainBridge{
    protected BlockchainInterface $blockchain;

    public function __construct(BlockchainInterface $blockchain)
    {
        $this->blockchain = $blockchain;
    }

    public function connect() {
        return $this->blockchain->connect();
    }

    public function getBalance(string $id) {
        return $this->blockchain->getData($id);
    }

    public function sendTransaction(array $data) {
        return $this->blockchain->sendTransaction($data);
    }
}

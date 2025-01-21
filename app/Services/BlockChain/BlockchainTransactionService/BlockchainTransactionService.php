<?php

namespace App\Services\Blockchain;

class BlockchainTransactionService extends BlockchainService
{
    public function processTransaction(array $transactionData)
    {
        $this->implementation->connect();
        return $this->implementation->sendTransaction($transactionData);
    }

    public function checkTransactionStatus(string $transactionId)
    {
        return $this->implementation->getTransactionStatus($transactionId);
    }
}

<?php

namespace App\Services\Blockchain;

interface BlockchainInterface
{
    public function connect();
    public function sendTransaction(array $transactionData);
    public function getTransactionStatus(string $transactionId);
}

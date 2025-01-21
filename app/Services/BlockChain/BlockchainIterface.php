<?php

namespace App\Services\Blockchain;

interface BlockchainImplementation
{
    public function connect();
    public function sendTransaction(array $transactionData);
    public function getTransactionStatus(string $transactionId);
}

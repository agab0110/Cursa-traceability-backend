<?php

namespace App\Services\Blockchain\Implementations;

use App\Services\Blockchain\BlockchainInterface;

class BlockchainImplementation implements BlockchainInterface
{
    public function connect()
    {
        return "Connesso alla blockchain";
    }

    public function sendTransaction(array $transactionData)
    {
        return [
            'transaction_id' => 'fake_tx_' . uniqid(),
            'status' => 'success',
        ];
    }

    public function getTransactionStatus(string $transactionId)
    {
        return [
            'transaction_id' => $transactionId,
            'status' => 'confirmed',
        ];
    }
}

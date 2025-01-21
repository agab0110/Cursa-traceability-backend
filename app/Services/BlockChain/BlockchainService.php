<?php

namespace App\Services\Blockchain;

abstract class BlockchainService
{
    protected $implementation;

    public function __construct(BlockchainImplementation $implementation)
    {
        $this->implementation = $implementation;
    }

    abstract public function processTransaction(array $transactionData);
}

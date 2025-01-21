<?php

namespace App\Http\Controllers;

use App\Services\Blockchain\BlockchainService;

class BlockchainController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService) {
        $this->blockchainService = $blockchainService;
    }
}

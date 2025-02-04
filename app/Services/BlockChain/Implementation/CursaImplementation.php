<?php

namespace App\Services\Blockchain\Implementation;

use App\Services\Blockchain\BlockchainInterface;

class CursaImplementation implements BlockchainInterface
{
    public function connect() {
        return "Connesso";
    }

    public function getData(string $id) {
        return "Get data success";
    }

    public function sendTransaction(array $data) {
        return "Send data success";
    }
}

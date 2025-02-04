<?php

namespace App\Services\Blockchain\Implementation;

use App\Services\Blockchain\BlockchainInterface;

/**
 * Implementazione interfaccia
 */
class CursaImplementation implements BlockchainInterface
{
    /**
     * Implementazione di connessione alla blockchain
     */
    public function connect() {
        return "Connesso";
    }

    /**
     * Implementazione getData
     *
     * @param string $id l'id della transazione
     * @return
     */
    public function getData(string $id) {
        return "Get data success";
    }

    /**
     * Implementazione sendData
     *
     * @param array $data i dati da inviare
     * @return
     */
    public function sendTransaction(array $data) {
        return "Send data success";
    }
}

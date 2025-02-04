<?php

namespace App\Services\Blockchain;

use App\Services\Blockchain\BlockchainInterface;

/**
 * Classe Bridge tra l'implementazione e l'astrazione
 */
class BlockchainBridge{
    protected BlockchainInterface $blockchain;

    /**
     * Dependency injection
     *
     * @param App\Services\Blockchain\BlockchainInterface $blockchain
     */
    public function __construct(BlockchainInterface $blockchain)
    {
        $this->blockchain = $blockchain;
    }

    /**
     * Funzione di connessione alla blockchain
     */
    public function connect() {
        return $this->blockchain->connect();
    }

    /**
     * Funzione per prendere i dati di una determinata transazione
     *
     * @param string $id l'id della transazione
     * @return App\Services\Blockchain\BlockchainInterface la funzione getData() dell'interfaccia
     */
    public function getData(string $id) {
        return $this->blockchain->getData($id);
    }

    /**
     * Funzione per inviare i dati alla blockchain
     *
     * @param array $data i dati da inviare
     * @return App\Services\Blockchain\BlockchainInterface la funzione sendData() dell'interfaccia
     */
    public function sendData(array $data) {
        return $this->blockchain->sendTransaction($data);
    }
}

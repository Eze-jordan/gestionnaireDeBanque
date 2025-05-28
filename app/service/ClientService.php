<?php

namespace App\Services;

use App\Models\Client;
use App\Dto\ClientDto;

class ClientService
{
    public function create(ClientDto $dto): Client
    {
        return Client::create([
            'nom' => $dto->nom,
            'email' => $dto->email,
            'telephone' => $dto->telephone,
        ]);
    }

    public function update(Client $client, ClientDto $dto): Client
    {
        $client->update([
            'nom' => $dto->nom,
            'email' => $dto->email,
            'telephone' => $dto->telephone,
        ]);
        return $client;
    }
}

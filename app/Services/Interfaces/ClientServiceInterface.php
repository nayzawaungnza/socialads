<?php

namespace App\Services\Interfaces;

use App\Models\Client;

interface ClientServiceInterface
{
    public function getClients($status = null);
    public function getClient($id);
    public function create(array $request);
    public function update(Client $client, array $request);
    public function destroy(Client $client);
    public function changeStatus(Client $client);
    public function getClientEloquent();
}
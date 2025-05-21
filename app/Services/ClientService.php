<?php

namespace App\Services;

use Exception;
use App\Models\Client;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\ClientRepository;
use App\Services\Interfaces\ClientServiceInterface;

class ClientService implements ClientServiceInterface
{
    protected $clientRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getClients($status = 1)
    {
        return $this->clientRepository->getClients( $status);
    }
    public function getClient($id)
    {

    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Client Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create Client'); 
        }
        DB::commit();
        return $client;
    }
    public function update(Client $client, array $data)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->update($client,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Client Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to Client update'); 
        }
        DB::commit();
        return $client;
    }
    public function destroy(Client $client)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->destroy($client);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Client deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Client'); 
        }
        DB::commit();
        return $client;
    }
    public function changeStatus(Client $client)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->changeStatus($client);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Client Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change Client status'); 
        }
        DB::commit();
        return $client;
    }
    public function getClientEloquent()
    {
        return $this->clientRepository->getClientEloquent();
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Exception;

class ClientController extends Controller
{
    private ClientService $clientService;


    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return ClientResource::collection($this->clientService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(ClientRequest $request)
    {
        try {
            return new ClientResource($this->clientService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(ClientRequest $request, Client $client)
    {
        try {
            return new ClientResource($this->clientService->update($request, $client));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Client $client)
    {
        try {
            $this->clientService->destroy($client);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Client $client)
    {
        try {
            return new ClientResource($this->clientService->show($client));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}

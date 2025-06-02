<?php

namespace App\Services;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginateRequest;


class ClientService
{
    public $client;
    public $clientFilter = ['name', 'email', 'contact_person'];


    /**
     * @throws Exception
     */
    public function list(PaginateRequest $request)
    {
        try {
            $requests = $request->all();
            $method = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType = $request->get('order_type') ?? 'desc';

            return Client::with('user')->where(
                function ($query) use ($requests) {
                    foreach ($requests as $key => $request) {
                        if (in_array($key, $this->clientFilter)) {
                            $query->where($key, 'like', '%' . $request . '%');
                        }
                    }
                }
            )->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(ClientRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->client = Client::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_person' => $request->contact_person,
                    'user_id' => Auth::id(),
                ]);
            });
            return $this->client;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(ClientRequest $request, Client $client)
    {
        try {
            DB::transaction(function () use ($client, $request) {
                $this->client = $client;
                $this->client->name = $request->name;
                $this->client->email = $request->email;
                $this->client->contact_person = $request->contact_person;
                $this->client->save();
            });
            return $this->client;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public
    function show(Client $client): Client
    {
        try {
            return $client;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */

    public
    function destroy(Client $client)
    {
        try {
            DB::transaction(function () use ($client) {
                $client->delete();
            });
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }
}

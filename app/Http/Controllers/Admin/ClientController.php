<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Enums\ClientStatusEnum;
use App\Enums\ClientRegistrationEnum;
use App\Http\Requests\Admin\ClientRequest;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate();
        return view('admin.clients.index', compact('clients'));        

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientStatus = ClientStatusEnum::labels();
        return view('admin.clients.create', compact('clientStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        DB::beginTransaction();

        $client = Client::create($request->validated());
        $balance = $request->balance ?? 0;

        $client->accountTransactions()->create([
            'user_id' => auth()->id(),
            'credit' =>  0,
            'debit' =>0,
            'balance' => $balance,
            'balance_after' => $balance,
            'client_id' => $client->id,
            'description' => 'Client Opening Balance',
        ]);

        DB::commit();

        session()->flash('success', 'Client created successfully.');
        return redirect()->route('admin.clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        $clientStatus = ClientStatusEnum::labels();
        return view('admin.clients.edit', compact('client', 'clientStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->validated());
        session()->flash('success', 'Client updated successfully.');
        return redirect()->route('admin.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        $client = Client::findOrFail($id);
        $client->accountTransactions()->delete();
        $client->delete();
        DB::commit();
        return  response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully.'
        ]);
    }
}

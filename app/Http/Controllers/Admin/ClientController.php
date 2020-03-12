<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $clients = Client::with('projects')->paginate(20);
        // return response()->json([
        //     'clients' => $clients
        // ]);
        return "Hello World";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        if ($client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ])) {
            return response()->json([
                'client' => $client
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $client = Client::find($id);
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->address = $request->address;

        if ($client->save()) {
            return response()->json([
                'client' => $client
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if ($client->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}

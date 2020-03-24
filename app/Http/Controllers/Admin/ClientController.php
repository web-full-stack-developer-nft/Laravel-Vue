<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Issue;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        
        $query = Client::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    public function all(Request $request)
    {
        $clients;
        if ($request->has('status')) {
            $clients = Client::where('status', $request->input('status'))->get();
        }else {
            $clients = Client::get();
        }

        return \response()->json($clients);
    }

    public function query($query='')
    {
        $clients = Client::where('name','like','%'.$query.'%')->get();
        return $clients;
    }

    public function issue($clientid)
    {
        return Issue::where('client_id',$clientid)->get();
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
            return response($client);
        }
    }

    public function create()
    {
        $client=new Client();
        return response($client->getTableColumns());
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

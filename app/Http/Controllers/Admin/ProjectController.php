<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ProjectController extends Controller
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
        
        $query = Project::eloquentQuery(
            $sortBy, 
            $orderBy, 
            $searchValue, [
            'client',
            'name',
        ]);

        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $project=new Project();
        return response($project->getTableColumns());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        if ($project = Project::create([
            'name' => $request->name,
            'client_id' => $request->client_id,
        ])) {
            return response()->json([
                'project' => $project
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
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::find($id);
        $project->name = $request->name;
        $project->client_id = $request->client_id;

        if ($project->save()) {
            return response()->json([
                'project' => $project
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
        $project = Project::find($id);
        if ($project->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}

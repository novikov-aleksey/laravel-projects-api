<?php

namespace App\Http\Controllers\API;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Project::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|in:' . implode(',', array_values(Project::$statuses)),
        ]);


        $project = Project::create(\request(['name', 'description', 'status']));

        return response()->json(['data' => $project], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json(['data' => $project], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Project              $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $request->validate($rules);

        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        return response()->json(['data' => $project], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return response()->json(['data' => $project], 200);
    }
}

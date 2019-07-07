<?php

namespace App\Http\Controllers\API;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    /**
     * Display all projects in desc order
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' =>  Project::orderBy('id', 'desc')->get()]);
    }

    /**
     * Create a new project
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'in:' . implode(',', array_values(Project::$statuses)),
        ]);


        $project = Project::create(\request(['name', 'description', 'status']));

        return response()->json(['data' => $project], 201);
    }

    /**
     * Show single project by provided ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json(['data' => $project], 200);
    }

    /**
     * Update project
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
     * Remove the project from database
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

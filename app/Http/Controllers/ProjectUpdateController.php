<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUpdatePostRequest;
use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Http\Request;

class ProjectUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUpdatePostRequest $request, Project $project)
    {

        $projectUpdate = new ProjectUpdate();
        $projectUpdate->user_id = auth()->user()->id;
        $projectUpdate->project_id = $project->id;
        $projectUpdate->text = $request->text;
        $projectUpdate->date = $request->date;
        $projectUpdate->save();

        return response([
            'project_update' => $projectUpdate
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectUpdate  $projectUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectUpdate $projectUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectUpdate  $projectUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectUpdate $projectUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectUpdate  $projectUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectUpdate $projectUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectUpdate  $projectUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectUpdate $projectUpdate)
    {
        //
    }
}

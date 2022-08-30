<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectPostRequest;
use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectItemResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            "projects" => ProjectItemResource::collection(Project::get())
        ]);
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
    public function store(ProjectPostRequest $request)
    {

        $project = new Project();
        $project->user_id = auth()->user()->id;

        $project->category_id = 1;
        $project->name = $request->name;
        $project->description = $request->description;

        if ($request->file('picture_url')) {
            $file = $request->file('picture_url');
            $filename = Str::slug($request->name, '_') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/projects/pictures'), $filename);
            $project->picture_url = $filename;
        }
        $project->instagram_url = $request->instagram_url;
        $project->facebook_url = $request->facebook_url;
        $project->twitter_url = $request->twitter_url;

        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;


        $project->maintenance_fee = $request->maintenance_fee;
        $project->target_amount = $request->target_amount;

        $project->first_choice_amount = $request->first_choice_amount;
        $project->second_choice_amount = $request->second_choice_amount;
        $project->third_choice_amount = $request->third_choice_amount;
        $project->fourth_choice_amount = $request->fourth_choice_amount;
        $project->save();

        return response([
            'project' => $project
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response([
            "project" => new ProjectDetailResource($project)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}

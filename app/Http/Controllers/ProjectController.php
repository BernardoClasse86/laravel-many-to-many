<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $trashed_data = $request->input('trashed');
        $user_id = Auth::id();

        if ($trashed_data) {

            $projects = Project::onlyTrashed()->where('user_id', $user_id)->get();
        } else {

            $projects = Project::where('user_id', $user_id)->get();
            // $projects = Project::all();
        }

        $trashed_num = Project::onlyTrashed()->get()->count();

        // dd($trashed_num);

        return view('projects.index', compact('projects', 'trashed_num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        $validated_data = $request->validated();

        $validated_data['slug'] = Str::slug($validated_data['title']);
        $validated_data['user_id'] = Auth::id();

        $newProject = Project::create($validated_data);

        if (isset($validated_data['technologies'])) {

            $newProject->technologies()->attach($validated_data['technologies']);
        }

        return to_route('projects.show', $newProject);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated_data = $request->validated();

        if ($validated_data['title'] !== $project->title) {

            $validated_data['slug'] = Str::slug($validated_data['title']);
        }

        $project->update($validated_data);

        if (isset($validated_data['technologies'])) {

            $project->technologies()->sync($validated_data['technologies']);
        } else {

            $project->technologies()->sync([]);
        }

        return to_route('projects.show', $project);
    }

    public function restore(Project $project)
    {
        if ($project->trashed()) {

            $project->restore();

            request()->session()->flash('restore_message', 'The project: ' . $project->title . ' is successfully restored');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->trashed()) {

            $project->forceDelete();

            request()->session()->flash('full_delete_message', 'The project: ' . $project->title . ' has been fully deleted');
        } else {

            $project->delete();

            request()->session()->flash('delete_message', 'The project: ' . $project->title . ' has been moved to the bin');
        }

        return to_route('projects.index');
    }
}

<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->search)){
            $projects = Project::where('name','like','%'.$request->search.'%')->latest()->paginate(6);
        }else{
            $projects = Project::latest()->paginate(6);
        }

        return view('project.index',[
            'projects' => $projects,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectCreateRequest $request)
    {
        Project::create([
            'name' => $request->project_name,
            'description' => $request->project_description,
        ]);
        return redirect()->route('project.index')->with('status','Project created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit',[
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update([
            'name' => $request->project_name,
            'description' => $request->project_description,
        ]);
        //return redirect()->route('project.index')->with('status','Project updated successfully');
        return redirect()->route('project.edit',$project)->with('status','Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index')->with('status','Project deleted successfully');
    }
    public function getProjects(Request $request)
    {
        $term = $request->input('term');
        $projects = Project::where('name','like','%'.$term.'%')->pluck('name');
        return response()->json($projects);
    }

    public function getProjectsWithId(Request $request)
    {
        $term = $request->input('term');
        $projects = Project::where('name','like','%'.$term.'%')->get(['id', 'name']);
        $formattedProjects = $projects->map(function ($project) {
            return ['label' => $project->name, 'value' => $project->id];
        });
        return response()->json($formattedProjects);
    }
}

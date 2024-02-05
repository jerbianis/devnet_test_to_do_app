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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            if (isset($request->search)) {
                $projects = Project::where('name', 'like', '%' . $request->search . '%')->latest()->paginate(6);
            } else {
                $projects = Project::latest()->paginate(6);
            }

            return view('project.index', [
                'projects' => $projects,
            ]);

        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectCreateRequest $request)
    {
        try {
            Project::create([
                'name' => $request->project_name,
                'description' => $request->project_description,
            ]);
            return redirect()->route('project.index')->with('status', 'Project created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Project $project)
    {
        try {
            return view('project.edit', [
                'project' => $project,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
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
        try {
            $project->update([
                'name' => $request->project_name,
                'description' => $request->project_description,
            ]);
            //return redirect()->route('project.index')->with('status','Project updated successfully');
            return redirect()->route('project.edit', $project)->with('status', 'Project updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return redirect()->route('project.index')->with('status', 'Project deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }
    public function getProjects(Request $request)
    {
        try {
            $term = $request->input('term');
            $projects = Project::where('name', 'like', '%' . $term . '%')->pluck('name');
            return response()->json($projects);
        } catch (\Exception $exception) {
            return response()->json(['status-error' => 'Sorry, an error occurred ('.$exception->getCode().')']);
        }
    }

    public function getProjectsWithId(Request $request)
    {
        try {
            $term = $request->input('term');
            $projects = Project::where('name', 'like', '%' . $term . '%')->get(['id', 'name']);
            $formattedProjects = $projects->map(function ($project) {
                return ['label' => $project->name, 'value' => $project->id];
            });
            return response()->json($formattedProjects);
        } catch (\Exception $exception) {
            return response()->json(['status-error' => 'Sorry, an error occurred ('.$exception->getCode().')']);
        }
    }
}

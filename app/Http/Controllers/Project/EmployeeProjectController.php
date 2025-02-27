<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class EmployeeProjectController extends Controller
{
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

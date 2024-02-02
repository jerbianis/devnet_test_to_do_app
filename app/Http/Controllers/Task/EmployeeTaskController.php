<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\PendingTaskCreateRequest;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeTaskController extends Controller
{
    //
    public function index(Request $request)
    {
        $todo_tasks = ProjectTask::with('project')
            ->where('assigned_to',Auth::user()->id)
            ->where('is_valid',1)
            ->where('status', 'todo');
        $doing_tasks = ProjectTask::with('project')
            ->where('assigned_to',Auth::user()->id)
            ->where('is_valid',1)
            ->where('status', 'doing');
        $done_tasks = ProjectTask::with('project')
            ->where('assigned_to',Auth::user()->id)
            ->where('is_valid',1)
            ->where('status', 'done');

        if (isset($request->selected_project_id) and isset($request->project)){
            $todo_tasks->where('project_id','=',$request->selected_project_id);
            $doing_tasks->where('project_id','=',$request->selected_project_id);
            $done_tasks->where('project_id','=',$request->selected_project_id);
        }
        if (isset($request->task)){
            $todo_tasks->where('name','like','%'.$request->task.'%');
            $doing_tasks->where('name','like','%'.$request->task.'%');
            $done_tasks->where('name','like','%'.$request->task.'%');
        }
        if (isset($request->estimation)){
            if ($request->estimation === '*'){
                $todo_tasks->where('estimation','=',null);
                $doing_tasks->where('estimation','=',null);
                $done_tasks->where('estimation','=',null);
            }else{
                $todo_tasks->where('estimation','=',$request->estimation);
                $doing_tasks->where('estimation','=',$request->estimation);
                $done_tasks->where('estimation','=',$request->estimation);
            }
        }
        if (isset($request->priority)){
            $todo_tasks->where('priority','=',$request->priority);
            $doing_tasks->where('priority','=',$request->priority);
            $done_tasks->where('priority','=',$request->priority);
        }

        return view('task.employee.index',[
            'todo_tasks' => $todo_tasks->get(),
            'doing_tasks' => $doing_tasks->get(),
            'done_tasks' => $done_tasks->get(),
        ]);
    }

    public function pending()
    {
        $pending_tasks = ProjectTask::with('project')
            ->where('assigned_to',Auth::user()->id)
            ->where('is_valid',0)->get();

        return view('task.employee.pending',[
            'tasks' => $pending_tasks
        ]);
    }

    public function store(PendingTaskCreateRequest $request)
    {
        $project = Project::find($request->selected_project_id);
        $task = new ProjectTask();
        $task->name = $request->task_name;
        $task->priority = $request->priority;
        $task->is_valid = 0;
        $task->estimation = $request->estimation;
        $task->assigned_to = Auth::user()->id;

        $project->tasks()->save($task);
        return redirect()->back()->with('status','Task request created successfully');
    }

    public function cancelRequest(ProjectTask $task)
    {
        $task->delete();
        return redirect()->back()->with('status','Task request canceled successfully');
    }

    public function estimate(Request $request,ProjectTask $task)
    {
        if ($task->estimation){
            return redirect()->back(403);
        }else{
            $request->validate([
                'estimation' => ['required',Rule::in(['S','M','L','XL'])],
            ]);
            $task->update([
                'estimation' => $request->estimation
            ]);
        }
        return redirect()->route('employee.task.index')->with('status','Task estimation saved');
    }

    public function toDo(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        if ($task->assigned_to != Auth::user()->id){
            return redirect()->back(403);
        }else{
            $task->update(['status' => 'todo']);
            return redirect()->back()->with('status', 'Task went to To Do list');
        }
    }

    public function doing(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        if ($task->assigned_to != Auth::user()->id){
            return redirect()->back(403);
        }else {
            $task->update(['status' => 'doing']);
            return redirect()->back()->with('status', 'Task went to Doing list');
        }
    }

    public function done(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        if ($task->assigned_to != Auth::user()->id){
            return redirect()->back(403);
        }else{
            $task->update(['status' => 'done']);
            return redirect()->back()->with('status', 'Task went to Done list');
        }
    }
}

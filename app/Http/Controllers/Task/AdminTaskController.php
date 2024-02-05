<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $todo_tasks = ProjectTask::with('assigned_to_user', 'project')
                ->where('is_valid', 1)
                ->where('status', 'todo');
            $doing_tasks = ProjectTask::with('assigned_to_user', 'project')
                ->where('is_valid', 1)
                ->where('status', 'doing');
            $done_tasks = ProjectTask::with('assigned_to_user', 'project')
                ->where('is_valid', 1)
                ->where('status', 'done');

            if (isset($request->selected_project_id) and isset($request->project)) {
                $todo_tasks->where('project_id', '=', $request->selected_project_id);
                $doing_tasks->where('project_id', '=', $request->selected_project_id);
                $done_tasks->where('project_id', '=', $request->selected_project_id);
            }
            if (isset($request->task)) {
                $todo_tasks->where('name', 'like', '%' . $request->task . '%');
                $doing_tasks->where('name', 'like', '%' . $request->task . '%');
                $done_tasks->where('name', 'like', '%' . $request->task . '%');
            }
            if (isset($request->estimation)) {
                if ($request->estimation === '*') {
                    $todo_tasks->where('estimation', '=', null);
                    $doing_tasks->where('estimation', '=', null);
                    $done_tasks->where('estimation', '=', null);
                } else {
                    $todo_tasks->where('estimation', '=', $request->estimation);
                    $doing_tasks->where('estimation', '=', $request->estimation);
                    $done_tasks->where('estimation', '=', $request->estimation);
                }
            }
            if (isset($request->priority)) {
                $todo_tasks->where('priority', '=', $request->priority);
                $doing_tasks->where('priority', '=', $request->priority);
                $done_tasks->where('priority', '=', $request->priority);
            }

            return view('task.admin.index', [
                'todo_tasks' => $todo_tasks->get(),
                'doing_tasks' => $doing_tasks->get(),
                'done_tasks' => $done_tasks->get(),
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
    public function store(TaskCreateRequest $request)
    {
        try {
            $project = Project::find($request->selected_project_id);
            $task = new ProjectTask();
            $task->name = $request->task_name;
            $task->priority = $request->priority;
            $task->is_valid = 1;
            if ($request->estimation) {
                $task->estimation = $request->estimation;
            }
            if (isset($request->employee)) {
                $employee_id = User::where('email', $request->selected_employee_email)->value('id');
                $task->assigned_to = $employee_id;
            }

            $project->tasks()->save($task);
            return redirect()->route('task.index')->with('status', 'Task created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectTask  $projectTask
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(ProjectTask $task)
    {
        try {
            $task = ProjectTask::with('project', 'assigned_to_user')->find($task->id);
            return view('task.admin.edit', [
                'task' => $task
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectTask  $projectTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskUpdateRequest $request, ProjectTask $task)
    {
        try {
            if (isset($request->employee)) {
                $employee_id = User::where('email', $request->selected_employee_email)->value('id');
                $task->assigned_to = $employee_id;
            }
            $data['name'] = $request->task_name;
            $data['priority'] = $request->priority;
            if ($request->estimation == '0') {
                $data['estimation'] = null;
            } else {
                $data['estimation'] = $request->estimation;
            }
            if (isset($request->employee)) {
                $employee_id = User::where('email', $request->selected_employee_email)->value('id');
                $data['assigned_to'] = $employee_id;
            } else {
                $data['assigned_to'] = null;
            }
            $task->update($data);

            return redirect()->route('task.index')->with('status', 'Task updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectTask  $projectTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProjectTask $task)
    {
        try {
            $task->delete();
            return redirect()->route('task.index')->with('status', 'Task deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function getEmployeesWithEmail(Request $request)
    {
        try {
            $term = $request->input('term');
            $employees = User::where('is_admin', 0)
                ->where(function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%');
                })
                ->get(['email', 'name']);
            $formattedEmployees = $employees->map(function ($employee) {
                return ['label' => $employee->name . ' : ' . $employee->email, 'value' => $employee->email];
            });
            return response()->json($formattedEmployees);
        } catch (\Exception $exception) {
            return response()->json(['status-error' => 'Sorry, an error occurred ('.$exception->getCode().')']);
        }
    }

    public function toDo(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        try {
            $task->update(['status' => 'todo']);
            return redirect()->back()->with('status', 'Task went to To Do list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function doing(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        try {
            $task->update(['status' => 'doing']);
            return redirect()->back()->with('status', 'Task went to Doing list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function done(ProjectTask $task): \Illuminate\Http\RedirectResponse
    {
        try {
            $task->update(['status' => 'done']);
            return redirect()->back()->with('status', 'Task went to Done list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function pending()
    {
        try {
            $pending_tasks = ProjectTask::with('project', 'assigned_to_user')
                ->where('is_valid', 0)->get();
            return view('task.admin.pending', [
                'tasks' => $pending_tasks
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function accept(ProjectTask $task)
    {
        try {
            $task->update(['is_valid' => 1]);
            return redirect()->back()->with('status', 'Task went to Done list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public function reject(ProjectTask $task)
    {
        try {
            $task->delete();
            return redirect()->back()->with('status', 'Task went to Done list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }

    public static function getPendingTaskCount()
    {
        return ProjectTask::where('is_valid',0)->count();
    }
}

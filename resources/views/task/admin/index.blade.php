@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-2">
                    <form id="filter-form" method="get" action="{{route('task.index')}}">
                        <div class="d-flex gap-2">
                            <div>
                                <input value="{{request('project')}}" class="form-control" type="text" id="autocomplete-input" name="project" placeholder="Select a Project">
                                <input value="{{request('selected_project_id')}}" type="hidden" id="selected-project-id-filter" name="selected_project_id">
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Search for a Task" name="task" value="{{request('task')}}">
                            </div>
                            <div>
                                <select class="form-control" name="estimation">
                                    <option value="" >Estimation</option>
                                    <option value="*" @if(request('estimation') == '*') selected @endif >*</option>
                                    <option value="S" @if(request('estimation') == 'S') selected @endif >S</option>
                                    <option value="M" @if(request('estimation') == 'M') selected @endif >M</option>
                                    <option value="L" @if(request('estimation') == 'L') selected @endif >L</option>
                                    <option value="XL" @if(request('estimation') == 'XL') selected @endif >XL</option>
                                </select>
                            </div>
                            <div>
                                <select class="form-control" name="priority">
                                    <option value="">Priority</option>
                                    <option value="low" @if(request('priority') == 'low') selected @endif >Low</option>
                                    <option value="medium" @if(request('priority') == 'medium') selected @endif >Medium</option>
                                    <option value="high" @if(request('priority') == 'high') selected @endif>High</option>
                                </select>
                            </div>
                            <button class="input-group-text btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>

                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Tasks</div>
                        <a
                            id="show-modal"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#createTaskModal"
                        >Create Task</a>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createProjectModalLabel">Create Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{route('task.store')}}">
                                    <div class="modal-body">
                                        @csrf

                                        <div class="mb-2">
                                            <label for="autocomplete-input-2" class="form-label">Project*</label>
                                            <!-- Text input for autocomplete -->
                                            <input value="{{old('project')}}" class="form-control @error('project') is-invalid @enderror @error('selected_project_id') is-invalid @enderror" type="text" id="autocomplete-input-2" name="project" placeholder="Select a project from the autocomplete list">
                                            @error('selected_project_id') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                            <!-- Hidden input to store the selected project ID -->
                                            <input value="{{old('selected_project_id')}}" type="hidden" id="selected-project-id" name="selected_project_id">
                                        </div>
                                        <div class="mb-2">
                                            <label for="task_name" class="form-label">Task*</label>
                                            <input type="text"
                                                   name="task_name"
                                                   id="task_name"
                                                   placeholder="Task"
                                                   value="{{old('task_name')}}"
                                                   class="form-control @error('task_name') is-invalid @enderror">
                                            @error('task_name') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label for="priority" class="form-label">Priority*</label>
                                            <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority">
                                                <option value="low" @if(old('priority') == 'low') selected @endif >Low</option>
                                                <option value="medium" @if(old('priority','medium') == 'medium') selected @endif>Medium</option>
                                                <option value="high" @if(old('priority') == 'high') selected @endif>High</option>
                                            </select>
                                            @error('priority') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label for="autocomplete-input-3" class="form-label">Assign To</label>
                                            <!-- Text input for autocomplete -->
                                            <input value="{{old('employee')}}" class="form-control @error('selected_employee_email') is-invalid @enderror" type="text" id="autocomplete-input-3" name="employee" placeholder="Select an employee from the autocomplete list">
                                            @error('selected_employee_email') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                            <!-- Hidden input to store the selected project ID -->
                                            <input value="{{old('selected_employee_email')}}" type="hidden" id="selected-employee-email" name="selected_employee_email">
                                        </div>
                                        <div class="mb-2">
                                            <label for="estimation" class="form-label">Estimation</label>
                                            <select class="form-control @error('estimation') is-invalid @enderror" name="estimation" id="estimation">
                                                <option value="0" @if(old('estimation','0') == '0') selected @endif >Estimation</option>
                                                <option value="S" @if(old('estimation') == 'S') selected @endif >S</option>
                                                <option value="M" @if(old('estimation') == 'M') selected @endif >M</option>
                                                <option value="L" @if(old('estimation') == 'L') selected @endif >L</option>
                                                <option value="XL" @if(old('estimation') == 'XL') selected @endif >XL</option>
                                            </select>
                                            @error('estimation') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($errors->count() > 0)
                        <script>
                            $(document).ready(function() {
                                // Trigger the modal when error found
                                $('#createTaskModal').modal('show');
                            });
                        </script>
                    @endif
                    <div class="card-body">

                        <div>
                            <div class="d-flex justify-content-between">
                                <div class="card" style="width: 33%;">
                                    <div class="card-header text-center"><h3 class="text-danger border-danger" style="border-bottom: 4px solid">To Do</h3></div>
                                        <div class="card-body">
                                            @foreach($todo_tasks as $task)
                                                <div class="p-1 mb-1" style="border: 1px solid #dddddd; border-radius: 5%;">
                                                    <div class="d-flex flex-wrap justify-content-center gap-1 mb-2">
                                                        <form method="post" action="{{route('task.doing',$task)}}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-outline-warning" >
                                                                Doing
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form method="post" action="{{route('task.done',$task)}}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-outline-success" >
                                                                Done
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center">
                                                        @if($task->priority == 'high')
                                                            {{--   High icon   --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708z"/>
                                                                <path fill-rule="evenodd" d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                                            </svg>
                                                        @elseif($task->priority == 'medium')
                                                            {{--   Medium icon   --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                            </svg>
                                                        @else
                                                            {{--   Low icon   --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                                <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                            </svg>
                                                        @endif
                                                        <div class="fw-bold fs-4">@if(isset($task->estimation)) {{$task->estimation}} @else * @endif</div>
                                                    </div>
                                                    <div class="fw-bold text-center" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                                    <div class="fw-bold text-center">{{$task->name}}</div>
                                                    <div class="text-center" style="color: #1e3a9a;">@if(isset($task->assigned_to)){{$task->assigned_to_user->name}} @else Not assigned @endif</div>
                                                    <div class="d-flex flex-wrap gap-1 mt-3 justify-content-center">
                                                        <a href="{{route('task.edit',$task->id)}}" class="btn text-white" style="background-color: darkorange;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                            </svg>
                                                        </a>
                                                        <form method="post" action="{{route('task.destroy',$task)}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="card"  style="width: 33%;">
                                    <div class="card-header text-center"><h3 class="text-warning border-warning" style="border-bottom: 4px solid">Doing</h3></div>
                                    <div class="card-body">
                                        @foreach($doing_tasks as $task)
                                            <div class="p-1 mb-1" style="border: 1px solid #dddddd; border-radius: 5%;">
                                                <div class="d-flex flex-wrap justify-content-center gap-1 mb-2">
                                                    <form method="post" action="{{route('task.todo',$task)}}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-danger" >
                                                            To Do
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form method="post" action="{{route('task.done',$task)}}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-success" >
                                                            Done
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="d-flex flex-column align-items-center">
                                                    @if($task->priority == 'high')
                                                        {{--   High icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708z"/>
                                                            <path fill-rule="evenodd" d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                                        </svg>
                                                    @elseif($task->priority == 'medium')
                                                        {{--   Medium icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                        </svg>
                                                    @else
                                                        {{--   Low icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                            <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                        </svg>
                                                    @endif
                                                    <div class="fw-bold fs-4">@if(isset($task->estimation)) {{$task->estimation}} @else * @endif</div>
                                                </div>
                                                <div class="fw-bold text-center" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                                <div class="fw-bold text-center">{{$task->name}}</div>
                                                <div class="text-center" style="color: #1e3a9a;">@if(isset($task->assigned_to)){{$task->assigned_to_user->name}} @else Not assigned @endif</div>
                                                <div class="d-flex flex-wrap gap-1 mt-3 justify-content-center">
                                                    <a href="{{route('task.edit',$task->id)}}" class="btn text-white" style="background-color: darkorange;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{route('task.destroy',$task)}}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card"  style="width: 33%;">
                                    <div class="card-header text-center"><h3 class="text-success border-success" style="border-bottom: 4px solid">Done</h3></div>
                                    <div class="card-body">
                                        @foreach($done_tasks as $task)
                                            <div class="p-1 mb-1" style="border: 1px solid #dddddd; border-radius: 5%;">
                                                <div class="d-flex flex-wrap justify-content-center gap-1 mb-2">
                                                    <form method="post" action="{{route('task.todo',$task)}}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-danger" >
                                                            To Do
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form method="post" action="{{route('task.doing',$task)}}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-warning" >
                                                            Doing
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="d-flex flex-column align-items-center">
                                                    @if($task->priority == 'high')
                                                        {{--   High icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708z"/>
                                                            <path fill-rule="evenodd" d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                                        </svg>
                                                    @elseif($task->priority == 'medium')
                                                        {{--   Medium icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                        </svg>
                                                    @else
                                                        {{--   Low icon   --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                            <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                        </svg>
                                                    @endif
                                                    <div class="fw-bold fs-4">@if(isset($task->estimation)) {{$task->estimation}} @else * @endif</div>
                                                </div>
                                                <div class="fw-bold text-center" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                                <div class="fw-bold text-center">{{$task->name}}</div>
                                                <div class="text-center" style="color: #1e3a9a;">@if(isset($task->assigned_to)){{$task->assigned_to_user->name}} @else Not assigned @endif</div>
                                                <div class="d-flex flex-wrap gap-1 mt-3 justify-content-center">
                                                    <a href="{{route('task.edit',$task)}}" class="btn text-white" style="background-color: darkorange;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{route('task.destroy',$task)}}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $("#autocomplete-input").autocomplete({
                source: function(request, response) {
                    // Make an Ajax request to fetch suggestions from the server
                    $.ajax({
                        url: "/dashboard/admin/get-projects-with-id", // Replace with your route
                        method: "GET",
                        data: { term: request.term },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    // Set the selected project ID in the hidden input
                    event.preventDefault();
                    $(this).val(ui.item.label);
                    $("#selected-project-id-filter").val(ui.item.value);
                    $("#filter-form").submit();
                },
            });
        });
    </script>
    <script>
        $(function() {
            $("#autocomplete-input-2").autocomplete({
                source: function(request, response) {
                    // Make an Ajax request to fetch suggestions from the server
                    $.ajax({
                        url: "/dashboard/admin/get-projects-with-id", // Replace with your route
                        method: "GET",
                        data: { term: request.term },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    // Set the selected project ID in the hidden input
                    event.preventDefault();
                    $(this).val(ui.item.label);
                    $("#selected-project-id").val(ui.item.value);
                },
                open: function() {
                    // Adjust z-index of suggestions
                    $(".ui-autocomplete").css("z-index", 9999);
                }
            });
        });
    </script>
    <script>
        $(function() {
            $("#autocomplete-input-3").autocomplete({
                source: function(request, response) {
                    // Make an Ajax request to fetch suggestions from the server
                    $.ajax({
                        url: "/dashboard/admin/get-employees-with-email", // Replace with your route
                        method: "GET",
                        data: { term: request.term },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    // Set the selected project ID in the hidden input
                    event.preventDefault();
                    $(this).val(ui.item.label);
                    $("#selected-employee-email").val(ui.item.value);
                },
                open: function() {
                    // Adjust z-index of suggestions
                    $(".ui-autocomplete").css("z-index", 9999);
                }
            });
        });
    </script>
@endsection

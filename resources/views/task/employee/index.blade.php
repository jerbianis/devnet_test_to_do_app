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
                    <form id="filter-form" method="get" action="{{route('employee.task.index')}}">
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
                        >Request Task</a>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createProjectModalLabel">Create Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{route('employee.task.store')}}">
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
                                            <label for="estimation" class="form-label">Estimation*</label>
                                            <select class="form-control @error('estimation') is-invalid @enderror" name="estimation" id="estimation">
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
                                                    <form method="post" action="{{route('employee.task.doing',$task)}}">
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
                                                    <form method="post" action="{{route('employee.task.done',$task)}}">
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
                                                    <div class="fw-bold fs-4">
                                                        @if(isset($task->estimation)) {{$task->estimation}}
                                                        @else
                                                            <div class="d-flex gap-2 mb-1 mt-1">
                                                                <div>*</div>
                                                                <div>
                                                                    <form method="post" action="{{route('employee.task.estimate',$task)}}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="d-flex gap-1">
                                                                            <select class="form-control @error('estimation') is-invalid @enderror" name="estimation" id="estimation">
                                                                                <option value="S" @if(old('estimation') == 'S') selected @endif >S</option>
                                                                                <option value="M" @if(old('estimation') == 'M') selected @endif >M</option>
                                                                                <option value="L" @if(old('estimation') == 'L') selected @endif >L</option>
                                                                                <option value="XL" @if(old('estimation') == 'XL') selected @endif >XL</option>
                                                                            </select>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                                                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                                                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-center" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                                <div class="fw-bold text-center">{{$task->name}}</div>
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
                                                    <form method="post" action="{{route('employee.task.todo',$task)}}">
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
                                                    <form method="post" action="{{route('employee.task.done',$task)}}">
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
                                                    <form method="post" action="{{route('employee.task.todo',$task)}}">
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
                                                    <form method="post" action="{{route('employee.task.doing',$task)}}">
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
                                                    <div class="fw-bold fs-4">
                                                        @if(isset($task->estimation)) {{$task->estimation}}
                                                        @else *
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-center" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                                <div class="fw-bold text-center">{{$task->name}}</div>
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
                        url: "/dashboard/employee/get-projects-with-id", // Replace with your route
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
                        url: "/dashboard/employee/get-projects-with-id", // Replace with your route
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
@endsection

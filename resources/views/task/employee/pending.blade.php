@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Pending Task Requests</div>
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
                        @if($tasks->isEmpty())
                            <h3>No pending task found</h3>
                        @endif
                        <div>
                            <div class="row d-flex">
                            @foreach($tasks as $task)
                                <div class="col-lg-3 text-center card py-2">
                                    <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                                        <div>
                                            <div>
                                                @if($task->priority == 'high')
                                                    {{--   High icon   --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         fill="currentColor" class="bi bi-chevron-double-up"
                                                         viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                                    </svg>
                                                @elseif($task->priority == 'medium')
                                                    {{--   Medium icon   --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                    </svg>
                                                @else
                                                    {{--   Low icon   --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         fill="currentColor" class="bi bi-chevron-double-down"
                                                         viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                        <path fill-rule="evenodd"
                                                              d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="fw-bold fs-4">
                                                {{$task->estimation}}
                                            </div>
                                            <div class="fw-bold" style="color: #1e3a9a;">{{$task->project->name}}</div>
                                            <div class="fw-bold">{{$task->name}}</div>
                                        </div>
                                        <div>
                                            <form method="post" action="{{route('employee.pending-task.destroy',$task)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mt-1 mb-0">Cancel Request</button>
                                            </form>
                                        </div>
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

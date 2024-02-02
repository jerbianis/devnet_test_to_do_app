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
                        <div><strong>Project :</strong> {{$task->project->name}} <strong>Task: </strong>{{$task->name}} </div>
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

                    <div class="card-body">

                        <div class="row">
                            <form method="post" action="{{route('task.update',$task)}}">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label for="task_name" class="form-label">Task*</label>
                                    <input type="text"
                                           name="task_name"
                                           id="task_name"
                                           placeholder="Task"
                                           value="{{old('task_name',$task->name)}}"
                                           class="form-control @error('task_name') is-invalid @enderror">
                                    @error('task_name') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="priority" class="form-label">Priority*</label>
                                    <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority">
                                        <option value="low" @if(old('priority',$task->priority) == 'low') selected @endif >Low</option>
                                        <option value="medium" @if(old('priority',$task->priority) == 'medium') selected @endif>Medium</option>
                                        <option value="high" @if(old('priority',$task->priority) == 'high') selected @endif>High</option>
                                    </select>
                                    @error('priority') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="autocomplete-input-3" class="form-label">Assign To</label>
                                    <!-- Text input for autocomplete -->
                                    <input value="{{old('employee',$task->assigned_to_user ? $task->assigned_to_user->name : '')}}" class="form-control @error('selected_employee_email') is-invalid @enderror" type="text" id="autocomplete-input-3" name="employee" placeholder="Select an employee from the autocomplete list">
                                    @error('selected_employee_email') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                    <!-- Hidden input to store the selected project ID -->
                                    <input value="{{old('selected_employee_email',$task->assigned_to_user ? $task->assigned_to_user->email : '')}}" type="hidden" id="selected-employee-email" name="selected_employee_email">
                                </div>
                                <div class="mb-2">
                                    <label for="estimation" class="form-label">Estimation</label>
                                    <select class="form-control @error('estimation') is-invalid @enderror" name="estimation" id="estimation">
                                        <option value="0" @if(old('estimation',$task->estimation ? '1' : '0') == '0') selected @endif >Estimation</option>
                                        <option value="S" @if(old('estimation',$task->estimation) == 'S') selected @endif >S</option>
                                        <option value="M" @if(old('estimation',$task->estimation) == 'M') selected @endif >M</option>
                                        <option value="L" @if(old('estimation',$task->estimation) == 'L') selected @endif >L</option>
                                        <option value="XL" @if(old('estimation',$task->estimation) == 'XL') selected @endif >XL</option>
                                    </select>
                                    @error('estimation') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            });
        });
    </script>
@endsection

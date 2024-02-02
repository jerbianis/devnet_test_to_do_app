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
                    <form method="get" action="{{route('project.index')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="autocomplete-input" placeholder="Search for project" name="search" value="{{request('search')}}">
                                    <button class="input-group-text btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Projects</div>
                        <a
                            id="show-modal"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#createProjectModal"
                        >Create Project</a>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createProjectModalLabel">Create Project</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{route('project.store')}}">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="project_name" class="form-label">Project*</label>
                                            <input type="text"
                                                   name="project_name"
                                                   id="project_name"
                                                   placeholder="Project"
                                                   value="{{old('project_name')}}"
                                                   class="form-control @error('project_name') is-invalid @enderror">
                                            @error('project_name') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="project_description" class="form-label">Project Description*</label>
                                            <textarea
                                                name="project_description"
                                                id="project_description"
                                                placeholder="Description"
                                                class="form-control @error('project_description') is-invalid @enderror">{{old('project_description')}}</textarea>
                                            @error('project_description') <p class="mx-1 text-danger">{{$message}}</p> @enderror
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
                                $('#createProjectModal').modal('show');
                            });
                        </script>
                    @endif
                    <div class="card-body">

                            <div class="row">
                                @foreach($projects as $project)
                                    <div class="col-lg-4 mb-4">
                                        <div class="card border-1" style="min-height: 19rem;">
                                            <div class="d-flex flex-column text-center m-3" >
                                                <h3 class="mb-1">{{$project->name}}</h3>
                                                <p class="small">{{\Carbon\Carbon::parse($project->created_at)->longRelativeDiffForHumans()}}</p>
                                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                                    <button class="btn btn-outline-danger" disabled>
                                                        {{$project->countToDoTasks()}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                        </svg>
                                                    </button>
                                                    <button class="btn btn-outline-warning" disabled>
                                                        {{$project->countDoingTasks()}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                                        </svg>
                                                    </button>
                                                    <button class="btn btn-outline-success" disabled>
                                                        {{$project->countDoneTasks()}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="mt-3 mb-1" style="min-height: 9vw;">
                                                    {{$project->description}}
                                                </div>
                                                <div class="d-flex flex-wrap gap-1 mt-3 justify-content-center">
                                                    <a href="{{route('task.index',['selected_project_id'=>$project->id,'project'=>$project->name])}}" class="btn text-white" style="background-color: dodgerblue;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-kanban" viewBox="0 0 16 16">
                                                            <path d="M13.5 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                            <path d="M6.5 3a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm-4 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm8 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{{route('project.edit',$project)}}" class="btn text-white" style="background-color: darkorange;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                        </svg>
                                                    </a>
                                                    <form method="post" action="{{route('project.destroy',$project)}}">
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
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-end">
                                    {{$projects->appends(request()->query())->links()}}
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
                        url: "/dashboard/admin/get-projects", // Replace with your route
                        method: "GET",
                        data: { term: request.term },
                        success: function(data) {
                            response(data);
                        }
                    });
                }
            });
        });
    </script>
@endsection

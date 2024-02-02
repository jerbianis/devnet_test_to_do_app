@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div><strong>Update Project: </strong>{{$project->name}}</div>
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

                    <div class="card-body">

                        <div class="row">
                            <form method="post" action="{{route('project.update',$project)}}">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label for="project_name" class="form-label">Project*</label>
                                    <input type="text"
                                           name="project_name"
                                           id="project_name"
                                           placeholder="Project Name"
                                           value="{{old('project_name',$project->name)}}"
                                           class="form-control @error('project_name') is-invalid @enderror">
                                    @error('project_name') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                </div>
                                <div>
                                    <label for="project_description" class="form-label">Project Description*</label>
                                    <textarea
                                        name="project_description"
                                        id="project_description"
                                        class="form-control @error('project_description') is-invalid @enderror">{{old('project_description',$project->description)}}</textarea>
                                    @error('project_description') <p class="mx-1 text-danger">{{$message}}</p> @enderror
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

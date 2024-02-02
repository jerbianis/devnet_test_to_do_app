@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pending Task Requests</div>

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
@endsection

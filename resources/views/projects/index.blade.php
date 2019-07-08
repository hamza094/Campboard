@extends('layouts.app')

@section('content')

<div class="row ">
    <div class="col-md-9 left-panel">
    <div class="user-project">
        <p class="user-project_content">My Projects <button class="float-right user-project_content_btn">Add Project</button></p>
    </div>
    <div class="row">
    @foreach($projects as $project)
<div class="col-md-3 project">
  <h3 class="project-heading"><a href="/projects/{{$project->slug}}">{{$project->title}}</a></h3>
   <p class="project-content">{{str_limit($project->description,70)}}</p>
        </div>
        @endforeach
        </div>
    </div>
    <div class="col-md-3 right-panel">
        This is a right side panel
    </div>
</div>


@endsection
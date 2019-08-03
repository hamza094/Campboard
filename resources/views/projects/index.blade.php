@extends('layouts.app')

@section('content')
 <div class="row">
    <div class="col-md-12 panel">
    <div class="user-project">
       <project-model></project-model>
        <p class="user-project_content">My Projects <button class="float-right user-project_content_btn"
         @click="$modal.show('project')" >Add Project</button></p>
    </div>
    <div class="row">
    @forelse($projects as $project)
<div class="col-md-3 project">
  <h3 class="project-heading"><a href="/projects/{{$project->slug}}">{{$project->title}}</a></h3>
   <p class="project-content">{{str_limit($project->description,70)}}</p>
       <form action="{{$project->path()}}" method="POST" class="float-right">
           @method('DELETE')
           @csrf
           <button type="submit" class="btn btn-link">Delete</button>
       </form>
        </div>
        @empty
        <h1 class="text-center mt-3"><emp>No Projects Yet! Create New Project</emp></h1>
        @endforelse
        </div>
    </div>
</div>


@endsection
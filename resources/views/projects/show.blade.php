@extends('layouts.app')

@section('content')

<div class="row panel">
     <div class="col-md-9">
    <p class="user-project_content">My Projects / {{$project->title}}<button class="float-right user-project_content_btn">Add Task</button></p>
   <div class="tasks">
       <span>task</span>
   </div>  
    </div>
    <div class="col-md-3 single-project">
        <h3 class="single-project_title">{{$project->title}}</h3>
        <p class="single-project_description">{{$project->description}}</p>
    </div>
</div>




@endsection
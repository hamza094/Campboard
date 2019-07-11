@extends('layouts.app')

@section('content')

<div class="row panel">
     <div class="col-md-9">
    <p class="user-project_content">My Projects / {{$project->title}}<button class="float-right user-project_content_btn">Add Task</button></p>
   <div class="task">
    <p class="user-project_content">Tasks</p>
     <div class="task-card">
        run berry run
    </div>
    <div class="task-card">
        <input type="text" name="task" placeholder="Add Task" class="task-card_input">
    </div>
   </div>
   <div class="notes">
       <p class="user-project_content">General Notes</p>
       <div class="form-group">
           <textarea name="notes" id="" cols="30" rows="10" class="form-control"></textarea>
       </div>
   </div>  
    </div>
    <div class="col-md-3 single-project">
        <h3 class="single-project_title">{{$project->title}}</h3>
        <p class="single-project_description">{{$project->description}}</p>
    </div>
</div>



@foreach($project->tasks as $task)
<p>{{$task->body}}</p>
@endforeach

@endsection
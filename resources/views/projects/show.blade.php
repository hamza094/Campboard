@extends('layouts.app')

@section('content')

<div class="row panel">
     <div class="col-md-9">
    <p class="user-project_content">My Projects / {{$project->title}}<button class="float-right user-project_content_btn">Add Task</button></p>
   <div class="task">
    <p class="user-project_content">Tasks</p>
    @foreach($project->tasks as $task)
     <div class="task-card">
       <form action="{{$task->path()}}" method="POST" class="was-validated">
        @method('PATCH')
        @csrf
       <div class="flex">
        <input type="text" name="body" class="task-card_input" value="{{$task->body}}">
        <input type="checkbox" name="completed" class="task-card_checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
           </div>
         </form>
    </div>
@endforeach

    <div class="task-card">
       <form action="{{$project->path().'/tasks'}}" method="POST">
          {{csrf_field()}}
           <input type="text" name="body" placeholder="Add Task" class="task-card_input">
       </form>
    </div>
   </div>
   <div class="notes">
       <p class="user-project_content">General Notes</p>
       <form action="{{$project->path()}}" method="POST">
       @method('PATCH')
        @csrf
       <div class="form-group">
           <textarea name="notes" id="" cols="30" rows="10" class="notes-form" placeholder="Anything special you want to make note of?">  {{$project->notes}}
           </textarea>
       </div>
       <button class="user-project_content_btn float-right" type="submit">Add Note</button>  
       </form>
       
   </div>  
    </div>
    <div class="col-md-3 single-project">
        <h3 class="single-project_title">{{$project->title}}</h3>
        <p class="single-project_description">{{$project->description}}</p>
    </div>
</div>





@endsection
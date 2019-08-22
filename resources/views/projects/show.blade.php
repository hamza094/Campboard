@extends('layouts.app')

@section('content')
     <edit-model :project="{{$project}}"></edit-model>
   <p class="user-project_content mt-5">My Projects / {{$project->title}}
    <span class="user-project_content-img">
     @foreach($project->members as $member)
    <img src="{{gravatar_url($member->email)}}" alt="{{$member->name}}'s avatar" class="rounded-circle img-responsive">
    @endforeach
    <img src="{{gravatar_url($project->owner->email)}}" alt="{{$project->owner->name}}'s avatar" class="rounded-circle img-responsive">
    </span>
     @if(auth()->user()->is($project->owner))
   <button class="float-right user-project_content_btn" @click="$modal.show('EditProject')">Edit Project</button>
   @endif
    </p>
    @if(auth()->user()->is($project->owner))
    <p class="user-project_content">Role:Admin</p>
    @else
    <p class="user-project_content">Role:Invited User</p>
    @endif
<div class="row panel">
    
     <div class="col-md-9">
     <div class="task">
    <p class="user-project_content">Tasks</p>
    @foreach($project->tasks as $task)
    <task inline-template :task="{{$task}}" v-cloak>
     <div class="task-card">
       <form action="{{$task->path()}}" method="POST" class="was-validated">
        @method('PATCH')
        @csrf
       <div class="flex">
        <input type="text" name="body" class="task-card_input  {{ $task->completed ? 'strike' : 'non-strike' }}" value="{{$task->body}}">
        <input type="checkbox" name="completed" class="task-card_checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
           </div>
         </form>
         <div>
           @if(auth()->user()->is($project->owner))
    <button class="btn btn-link btn-lg" @click="destroy"><i class="far fa-trash-alt"></i></button>
    @endif
</div>  
</div>
         </task>
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
           <textarea name="notes" id="" cols="30" rows="10" class="notes-form" placeholder="  Anything special you want to make note of?">  {{$project->notes}}
           </textarea>
       </div>
       <button class="user-project_content_btn float-right" type="submit">Add Note</button>  
       </form>
           @include ('projects.errors')

   </div>  
    </div>
    <div class="col-md-3">
       <div class="single-project">
        <h3 class="single-project_title">{{$project->title}}</h3>
        <p class="single-project_description">{{$project->description}}</p>
        @can ('manage', $project)
        <form action="{{$project->path()}}" method="POST" class="float-right">
           @method('DELETE')
           @csrf
            <button type="submit" class="btn btn-outline-danger">Delete</button>
       </form>
       @endcan
        </div>
        <div class="activity">
         @include('projects.activities.card')
        </div>
        @if(auth()->user()->is($project->owner))
        <div class="single-project">
        <h3 class="single-project_title">Invite a User</h3>
         <div class="email-card">
       <form action="{{$project->path().'/invitations'}}" method="POST">
          {{csrf_field()}}
           <input type="email" name="email" placeholder="Add Email" class="email-card_input">
       </form>
    </div>
        @include ('projects.errors', ['bag' => 'invitations']) 
        </div>
        @endif
    </div>
</div>





@endsection
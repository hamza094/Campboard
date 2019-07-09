@extends('layouts.app')

@section('content')

<h3>{{$project->title}}</h3>


<p>{{$project->description}}</p>

@foreach($project->tasks as $task)
<p>{{$task->body}}</p>
@endforeach

@endsection
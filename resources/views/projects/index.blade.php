@extends('layouts.app')

@section('content')

@foreach($projects as $project)
<div>
<h3><a href="/projects/{{$project->slug}}">{{$project->title}}</a></h3>
    <span class="btn btn-link float-right"><a href="/projects/create">Create new project</a></span>
</div>
<p>{{$project->description}}</p>
@endforeach


@endsection
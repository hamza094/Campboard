@extends('layouts.app')

@section('content')
<form action="{{$project->path()}}" method="POST">
       @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control"  value="{{$project->title}}" name="title" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">
                {{$project->description}}
            </textarea>
        </div>
        <button class="btn btn-primary">Update</button>
</form>
@endsection
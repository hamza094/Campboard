@extends('layouts.app')

@section('content')
<form action="/projects" method="post">
           {{csrf_field()}}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control"  name="title" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">
                
            </textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
</form>
@endsection
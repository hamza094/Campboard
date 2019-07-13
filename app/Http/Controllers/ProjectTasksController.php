<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

use App\Project;
use Auth;

class ProjectTasksController extends Controller
{
    public function store(Project $project,Request $request){
        
          $this->validate($request, [
            'body'=>'required',
        ]);
        
      if(auth()->id() !== (int) $project->user_id){
           abort(403);
    }
        $project->addTask(request('body'));
        return redirect($project->path());
    
    }
    
    public function update(Project $project,Task $task){
        $task->update([
            'body'=>request('body'),
            'completed'=>request()->has('completed')
        ]);
        
        return redirect($project->path());
    }
}

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
        
      $this->authorize('update',$project);
        $project->addTask(request('body'));
        return redirect($project->path());
    
    }
    
    public function update(Project $project,Task $task){
        $this->authorize('update',$task->project);
        $task->update([
            'body'=>request('body')]);
        
         if(request('completed')){
            $task->complete();
        }else{
              $task->incomplete();
        }
        
        return redirect($project->path());
    }
}

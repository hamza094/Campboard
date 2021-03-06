<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

use Auth;

use App\Notifications\ProjectUpdate;


class ProjectsController extends Controller
{
    
    public function index(){
        
        $projects=auth()->user()->accesibleProjects();
        return view('projects.index',compact('projects'));
    }
    
    public function create(){
        return view('projects.create');
    }
    
    
    public function store(Request $request){
        
         $this->validate($request, [
           'title'=>'required',
           'description'=>'required',
           'notes'=>'max:255'
            
        ]);
              
        $project = Project::create([
                'user_id'=>auth()->id(),
                'title'=>request('title'),
                'slug'=>str_slug($request->title), 
                'description'=>request('description'),
                'notes'=>request('notes')
                ]);
        
        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }
        
        if(request()->wantsJson()){
            return ['message'=>$project->path()];
        }
        
        return redirect($project->path());
    }
    
      
    public function show(Project $project)
    {
        $this->authorize('update',$project);
        return view('projects.show',compact('project'));
    }
    
      public function update(Project $project){
        $this->authorize('update',$project);
       $project->update($this->validateRequest());
           if(request()->wantsJson()){
            return ['message'=>$project->path()];
        }
        foreach($project->members as $member){
            $member->notify(new ProjectUpdate($project));
        }
        $project->owner->notify(new ProjectUpdate($project));  
        return redirect($project->path())->with('flash','Updated Successfully');
          
    }
    
    public function edit(Project $project){
        return view('projects.edit',compact('project'));
    }
    
    public function destroy(Project $project){
        $this->authorize('manage',$project);
        $project->delete();
        return redirect('/projects')->with('flash','Project Deleted Successfully');
    }
    
    protected function validateRequest(){
        return request()->validate([
        'title'=>'sometimes|required',
           'description'=>'sometimes|required',
           'notes'=>'nullable'    
        ]);
        
    }
}

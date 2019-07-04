<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

use Auth;

class ProjectsController extends Controller
{
    
    public function index(){
        
        $projects=auth()->user()->projects;
        return view('projects.index',compact('projects'));
    }
    
    public function create(){
        return view('projects.create');
    }
    
    
    public function store(Request $request){
        
         $this->validate($request, [
            'title'=>'required',
             'description'=>'required',
                                    
        ]);
        $project = Project::create([
                'user_id'=>auth()->id(),
                'title'=>request('title'),
                'description'=>request('description'),
                ]);
        
        return redirect('/projects');
    }
    
      
    public function show(Project $project)
    {
        if(auth()->id() !== (int) $project->user_id){
            abort(403);
        }
        return view('projects.show',compact('project'));
    }
}

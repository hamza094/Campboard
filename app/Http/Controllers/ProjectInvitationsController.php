<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;

use App\Project;

use Auth;

use App\User;

use Session;





class ProjectInvitationsController extends Controller
{
    public function store(Project $project,ProjectInvitationRequest $request){
        $user = Auth::user();
      
       $user=User::whereEmail(request('email'))->first();
        
    if($project->owner->id == $user->id){
        return redirect($project->path())->with('flash','You are the owner of this project');    
     }
    if (! $project->members->contains($user->id)) {
        $project->invite($user);
        
         $project->invitedUser($user);        
         return redirect($project->path())->with('flash','User Invited Successfully');   
            
    }
           
      return redirect($project->path())->with('flash','User is already invited');    
    }
}

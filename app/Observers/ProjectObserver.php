<?php

namespace App\Observers;

use App\Project;
use App\Activity;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
       $project->recordActivity('created_project');
    }

    /**
     * Handle the project "updating" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    
    public function updating(Project $project)
    {
        $project->old = $project->getOriginal();
    }
    
    
    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $project->recordActivity('updated_project');
       
    }

}

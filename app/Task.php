<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
     use RecordActivity;
    
    protected $guarded=[];
    
    protected $touches=['project'];
    
    protected $casts=['completed'=>'boolean'];
    
     /**
     * Model events that should trigger new activity.
     * 
     * @var array
     */
    protected static $recordableEvents = ['created', 'deleted'];
    
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function path()
    {
        return "/projects/{$this->project->slug}/tasks/{$this->id}";
    }
    
     public function activity(){
        return $this->morphMany(Activity::class,'subject')->latest();
    }
    
    public function complete(){
        $this->update(['completed'=>true]);
        $this->recordActivity('updated_task');
     }
    
     public function incomplete(){
        $this->update(['completed'=>false]);
        $this->recordActivity('incompleted_task');
    }
}

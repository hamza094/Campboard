<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded=[];
    
     public function getRouteKeyName()
    {
        return 'slug';
    }

  public static function boot()
    {
        parent::boot();
        static::created(function ($project) {
            $project->update(['slug'=>$project->title]);
        });
    }
    
     public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function tasks(){
        return $this->hasMany(Task::class);
    }
    
    public function path()
    {
        return "/projects/{$this->slug}";
    }
    
     public function addTask($body)
     {
        return $this->tasks()->create(compact('body'));

     }
}


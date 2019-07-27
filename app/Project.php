<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordActivity;
    
    protected $guarded=[];
    
        
     public function getRouteKeyName()
    {
        return 'slug';
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
    
    public function invite(User $user)
    {
        return $this->members()->attach($user);    
    }
    
    public function members()
    {
        return $this->belongsToMany(User::class,'project_memebers');
    }
}


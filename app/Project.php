<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\UserInvitation;
use App\Notifications\TaskAdded;

class Project extends Model
{
    use Notifiable;
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
         foreach($this->members as $member){
            $member->notify(new TaskAdded($this));
        }
        
        $this->owner->notify(new TaskAdded($this)); 
         
        return $this->tasks()->create(compact('body'));

     }
    
     public function addTasks($tasks)
    {
          return $this->tasks()->createMany($tasks);
         
    }
    
    public function invite(User $user)
    {
        $user->notify(new UserInvitation($this));
        return $this->members()->attach($user);    
        
    }
    
    public function members()
    {
        return $this->belongsToMany(User::class,'project_memebers');
    }
}


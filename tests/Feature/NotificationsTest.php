<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A notification feature test.
     *
     * @return void
     */
    
    public function setup(){
        parent::setUp();
            
        $this->signIn();    
    }
    
    /** @test */
    public function invited_user_get_notification()
    {
        $foster=create('App\User');
        $this->assertCount(0,$foster->fresh()->notifications);
        $project=create('App\Project');
        $project->invite($foster);
        $this->assertCount(1,$foster->fresh()->notifications);
    }
    
    /** @test */
    public function a_user_can_mark_notification_as_read()
    {
        $foster=create('App\User');
        $project=create('App\Project');
        $project->invite($foster);
        $this->signIn($foster);
        $this->assertCount(1,$foster->fresh()->unreadNotifications);
        $notificationId=$foster->unreadNotifications->first()->id;
        $this->delete("{$foster->id}/notifications/{$notificationId}");
       $this->assertCount(0, $foster->fresh()->unreadNotifications);
    }
    
    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $foster=create('App\User');
        $project=create('App\Project');
        $project->invite($foster);
        $this->signIn($foster);
        $response=$this->getJson("{$foster->id}/notifications")->json();
        $this->assertCount(1,$response);
    }
    
    /** @test */
    public function a_user_can_get_notification_when_project_update(){
        $foster=create('App\User');
        $this->assertCount(0,$foster->fresh()->notifications);
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $project->invite($foster);
        $this->patch($project->path(), ['title'=>'title changed','description'=>'description changed']);
        $this->assertCount(2,$foster->fresh()->notifications);
    }
    
      /** @test */
    public function a_user_can_get_notification_when_task_added(){
        $foster=create('App\User');
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $project->invite($foster);
        $task=create('App\Task');
        $this->post($project->path().'/tasks',$task->toArray());
       $this->assertCount(2,$foster->fresh()->notifications);
    }
    
}

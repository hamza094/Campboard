<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A Activity test.
     *
     * @return void
     */
    
    /** @test */
    public function creating_a_project()
    {
        $project=create('App\Project');
        $this->assertCount(1,$project->activity);
       tap($project->activity->last(), function ($activity) {
             $this->assertEquals('created_project',$activity->description);
            $this->assertNull($activity->changes);
        });
    }
    
    /** @test*/
     public function updating_a_project()
    {
        $project=create('App\Project');
        $originalTitle = $project->title;
        $project->update(['title'=>'changed']);
        $this->assertCount(2,$project->activity);
        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project',$activity->description);
              $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];
            $this->assertEquals($expected, $activity->changes);
        });
    }
    
    /** @test */
    public function creating_a_task(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->assertCount(2,$project->activity);
       tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
           $this->assertEquals('test task',$activity->subject->body);
         });
    }  
    
     /** @test */
    public function updating_a_task(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
        $this->assertCount(3,$project->activity);
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('updated_task',$activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
           $this->assertEquals('changed',$activity->subject->body);
         });
    }  
    
      /** @test */
    public function incompleting_a_task(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
         $this->patch($task->path(), ['body' => 'changed','completed'=>false]);
        $this->assertCount(4,$project->activity);
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('incompleted_task',$activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
           $this->assertEquals('changed',$activity->subject->body);
         });
    }  
    
        /** @test */
    public function deleting_a_task(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $task->delete();
        $this->assertCount(3,$project->activity);
        $this->assertEquals('deleted_task',$project->activity->last()->description);
    }
    
    /** @test */
    public function inviting_user(){
        $owner=$user=create('App\User');
        $this->signIn($owner);
        $project=create('App\Project',['user_id'=>$owner->id]);
        $InvitedUser=create('App\User');
        $this->post($project->path().'/invitations',[
            'email'=>$InvitedUser->email
        ])->assertRedirect($project->path());
        $this->assertCount(2,$project->activity);
        $this->assertEquals('user_created',$project->activity->last()->description);

    }
    
                
}

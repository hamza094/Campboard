<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A ProjectTasks test.
     *
     * @return void
     */
    
      /** @test */
    public function task_requires_a_body(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=make('App\Task',['body'=>null]);
        $this->post($project->path().'/tasks',$task->toArray())
            ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function a_project_can_have_a_task()
    {
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=create('App\Task');
        $this->post($project->path().'/tasks',$task->toArray());
        $this->assertDatabaseHas('tasks',['body'=>$task->body]);
        $this->get($project->path())->assertSee($task->body);
    }
    
    /** @test */
    public function a_guest_cannot_add_tasks_to_project(){
        $project=create('App\Project');
         $this->post($project->path() . '/tasks')
            ->assertRedirect('login');
    }
    
     /** @test */
    public function only_project_owner_can_add_tasks(){
        $this->signIn();
        $project=create('App\Project');
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }
     
      /** @test */    
      public function only_project_owner_can_update_tasks(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed']);
        $this->assertDatabaseHas('tasks',['body'=>'changed']);
    }
    
      /** @test */    
      public function only_the_owner_can_update_tasks(){
        $this->signIn();
        $project=create('App\Project');
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed','completed'=>true])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks',['body'=>'changed','completed'=>true]);
        
    }
    
    /** @test */
    public function only_project_owner_can_delete_task(){
        $this->WithOutExceptionHandling();
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->delete($task->path());
        $this->assertDatabaseMissing('tasks',['id'=>$task->id]);
    }
    
    /** @test */
    public function task_marked_as_completed(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
        $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>true]);
    }
    
      /** @test */
    public function task_marked_as_incomplete(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=$project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
         $this->patch($task->path(), ['body' => 'changed','completed'=>false]);
        $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>false]);
    }
    
    
   }

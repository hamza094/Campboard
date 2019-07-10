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
}

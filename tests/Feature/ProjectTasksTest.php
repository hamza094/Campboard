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
    public function a_project_can_have_a_task()
    {
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $task=create('App\Task');
        $this->post($project->path().'/tasks',$task->toArray());
        $this->assertDatabaseHas('tasks',['body'=>$task->body]);
        $this->get($project->path())->assertSee($task->body);
    }
}

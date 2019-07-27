<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class ProjectTest extends TestCase
{
     use RefreshDatabase;
    
    /**
     * A projects unit test .
     *
     * @return void
     */
    
      /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = create('App\Project');
        $this->assertInstanceOf('App\User', $project->owner);
    }
    
    /** @test */
    public function it_can_add_task(){
          $project = create('App\Project');
        $task = $project->addTask('Test task');
        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
    
    /** @test */
     public function a_project_has_tasks()
    {
        $project = create('App\Project');
        $this->assertInstanceOf(Collection::class, $project->tasks);
    }
    
    /** @test */
    public function it_can_invites_a_user(){
        $project = create('App\Project');
        $project->invite($user=create('App\User'));
        $this->assertTrue($project->members->contains($user));
    }
}

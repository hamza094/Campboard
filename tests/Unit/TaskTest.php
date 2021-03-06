<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A tasktest unit test.
     *
     * @return void
     */
    
    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = create('App\Task');
        $this->assertInstanceOf('App\Project', $task->project);
    }
    
    /** @test*/
    public function it_can_be_completed(){
        $task = create('App\Task');
        $this->assertFalse($task->completed);
        $task->complete();
        $this->assertTrue($task->fresh()->completed);
        $this->assertEquals(1,$task->project->tasks_count);
    }
    
     /** @test*/
    public function it_can_be_incompleted(){
        $task = create('App\Task');
        $task->complete();
        $this->assertEquals(1,$task->project->tasks_count);
        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->fresh()->completed);
        $this->assertEquals(0,$task->project->tasks_count);
    }
    
    
}

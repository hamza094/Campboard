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
}

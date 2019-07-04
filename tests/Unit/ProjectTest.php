<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}

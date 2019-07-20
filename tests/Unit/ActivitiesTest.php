<?php

namespace Tests\Unit;

use App\Activity;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivitiesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    /** @test */
    public function it_has_a_user()
    {
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $this->assertEquals(auth()->id(), $project->activity->first()->user->id);
    }
}

<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A users unit test .
     *
     * @return void
     */
       
      /** @test */
    public function a_user_has_projects()
    {
        $user = create('App\User');
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    
    /** @test */
    public function a_user_has_accessible_projects(){
        //john signed in
        $john=create('App\User');
        $this->signIn($john);
        $project=create('App\Project',['user_id'=>$john->id]);
        $this->assertCount(1,$john->accesibleProjects());
        
        //nick signedIn
        $nick=create('App\User');
        $this->signIn($nick);
        
        //sally signedin
        $sally=create('App\User');
        $this->signIn($sally);
        $project2=create('App\Project',['user_id'=>$sally->id]);
        $project2->invite($nick);
        $this->assertCount(1,$john->accesibleProjects());
               
        $project2->invite($john);
        $this->assertCount(2,$john->accesibleProjects());
        
    }
}

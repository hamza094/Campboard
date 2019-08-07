<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * An InvitationUsersTest test.
     *
     * @return void
     */
    
    /** @test */
    public function a_project_owner_can_invite_user(){
        $owner=$user=create('App\User');
        $this->signIn($owner);
        $project=create('App\Project',['user_id'=>$owner->id]);
        $InvitedUser=create('App\User');
        $this->post($project->path().'/invitations',[
            'email'=>$InvitedUser->email
        ])->assertRedirect($project->path());
       $this->assertTrue($project->members->contains($InvitedUser));
    }
    
    /** @test */
    public function a_non_owner_can_not_invite_user(){
        $project=create('App\Project');
        $user=create('App\User');
        $this->signIn($user);
        $this->post($project->path().'/invitations')
            ->assertStatus(403);
        $project->invite($user);
        $this->post($project->path().'/invitations')
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_email_must_be_a_valid_campboard_account(){
         $owner=$user=create('App\User');
        $this->signIn($owner);
        $project=create('App\Project',['user_id'=>$owner->id]);
          $this->post($project->path().'/invitations',[
            'email'=>'notauser@example.com'
        ])->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Campboard account.'
            ],null, 'invitations');
        
    }
    
    /** @test */
    public function invited_user_may_update_project()
    {
        $project=create('App\Project');
        $project->invite($newUser=create('App\User'));
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store',$project),$task=['body'=>'task added']);
        $this->assertDatabaseHas('tasks',$task);
        $this->assertEquals($project->activity->last()->user_id, $newUser->id);

    }
    
    /** @test */
    public function invited_user_can_not_delete_project(){
        $project=create('App\Project');
        $user=create('App\User');
        $project->invite($user);
        $this->signIn($user);
        $this->delete($project->path())
        ->assertStatus(403);
        $this->assertDatabaseHas('projects',['id'=>$project->id]);
    }
    
}

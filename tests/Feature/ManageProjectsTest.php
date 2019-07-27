<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\User;

class ManageProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * A Project test.
     *
     * @return void
     */
    
    
    /** @test */
    public function guests_cannot_manage_projects(){
        $project=create('App\Project');
        $this->get('/projects')->assertRedirect('login');
        $this->delete('/projects/{project}')->assertRedirect('login');
       $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    } 
    

    /** @test */    
    public function only_authenticated_user_can_create_a_project()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
        $attributes=factory(Project::class)->raw(['user_id'=>auth()->id()]);
        $this->followingRedirects()->post('/projects',$attributes)
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description']);
        $this->assertDatabaseHas('projects',$attributes);
            
    }
    
    
  /** @test */
    public function project_requires_a_title(){
    $this->signIn();
    $project=make('App\Project',[
            'title'=>null
        ]);
        $this->post('/projects',$project->toArray())
            ->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function project_requires_a_description(){
    $this->signIn();
    $project=make('App\Project',[
            'description'=>null
        ]);
        $this->post('/projects',$project->toArray())
            ->assertSessionHasErrors('description');
    }
    
    /** @test */
    public function an_authorized_user_can_view_his_project(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
    
  
       /** @test */
    public function an_unAuthorized_user_can_not_view_others_project(){
        $this->signIn();
        $project=create('App\Project');
        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_project(){
         $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
         $this->get($project->path().'/edit')->assertStatus(200);
        $title='title changed';
        $description='description changed';
        $this->patch($project->path(), ['title'=>$title,'description'=>$description]);
        $this->assertDatabaseHas('projects',['title'=>$title,'description'=>$description]);
    }
    
         /** @test */
    public function an_unAuthorized_user_can_not_update_others_project(){
        $this->signIn();
        $project=create('App\Project');
        $this->patch($project->path(), ['notes' => 'changed'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('projects',['notes'=>'changed']);
    }
    
    /** @test */
    public function authorized_user_can_delete_his_projects(){
         $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $this->delete($project->path());
        $this->assertDatabaseMissing('projects',['id'=>$project->id]);
    }
    
     /** @test */
    public function Unathorized_user_can_not_delete_project(){
        $this->signIn();
        $project=create('App\Project');
        $this->delete($project->path())->assertStatus(403);
        $this->assertDatabaseHas('projects',['id'=>$project->id]);
    }
    
    /** @test*/
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_desktop(){
        $this->signIn();
        $project=create('App\Project');
        $project->invite(auth()->user());
        $this->get('/projects')
            ->assertSee($project->title);
    }  
    
}

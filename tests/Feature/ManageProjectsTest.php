<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
       $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    } 
    

    /** @test */    
    public function only_authenticated_user_can_create_a_project()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,
        ];
        $this->post('/projects',$attributes);
        $this->assertDatabaseHas('projects',$attributes);
        $this->get('/projects')->assertSee($attributes['title']);
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
        $this->withExceptionHandling();
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
    
    /** @test */
    public function an_authorized_user_view_all_his_projects(){
        $this->signIn();
        $project=create('App\Project',['user_id'=>auth()->id()]);
        $this->get('/projects')
           ->assertSee($project->title)
           ->assertSee($project->description);
    }
      
       /** @test */
    public function an_unAuthorized_user_can_not_view_others_project(){
        $this->withExceptionHandling();
        $this->signIn();
        $project=create('App\Project');
        $this->get($project->path())
            ->assertStatus(403);
    }

}

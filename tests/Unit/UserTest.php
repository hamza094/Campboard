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
}

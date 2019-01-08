<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_can_not_create_a_post() {
        $this->withExceptionHandling();

        $post = factory('App\Post')->make();

        $this->post('/api/posts', $post->toArray())
             ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_create_a_post() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->make(['user_id' => $user->id]);

        $this->post('/api/posts', $post->toArray());

        $this->assertDatabaseHas('posts', $post->toArray());
    }

    /** @test */
    public function title_field_is_required() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->make(['title' => null]);

        $this->withExceptionHandling()
             ->post('/api/posts', $post->toArray())
             ->assertStatus(422);
    }

    /** @test */
    public function body_field_is_required() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->make(['body' => null]);

        $this->withExceptionHandling()
             ->post('/api/posts', $post->toArray())
             ->assertStatus(422);

    }
}

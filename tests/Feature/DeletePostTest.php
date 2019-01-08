<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_their_posts() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->create(['user_id' => $user->id]);

        $this->delete('/api/posts/' . $post->id);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function an_unauthenticated_user_can_not_delete_any_post() {

        $post = factory('App\Post')->create();


        $this->withExceptionHandling()
             ->delete('/api/posts/' . $post->id)
             ->assertStatus(401);
    }

    /** @test */
    public function an_unauthorized_user_can_not_delete_their_posts() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->create(['user_id' => 10]);

        $this->withExceptionHandling()
             ->delete('/api/posts/' . $post->id)
             ->assertStatus(403);
    }
}

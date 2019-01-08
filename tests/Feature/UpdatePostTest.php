<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_authorized_user_can_edit_their_posts() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->create(['user_id' => $user->id]);

        $this->put('/api/posts/' . $post->id, ['title' => 'update title', 'body' => 'update body', 'channel_id' => 1])
             ->assertStatus(204);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_comment() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $post = factory('App\Post')->create();

        $comment = factory('App\Comment')->make([
            'user_id' => $user->id,
            'post_id' => $post->id
            ]);


        $this->post('/api/posts/' . $post->id . '/comments', $comment->toArray());

        $this->assertDatabaseHas('comments', $comment->toArray());
    }
}

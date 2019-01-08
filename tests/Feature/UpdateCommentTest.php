<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_update_their_comments() {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        $this->withExceptionHandling()
             ->put('/api/comments/' . $comment->id, ['body' => 'update'])
             ->assertStatus(204);
    }
}

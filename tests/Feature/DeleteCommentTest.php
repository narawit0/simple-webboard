<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_delete_their_comments() {
        $user = factory('App\User')->create();

        $this->actingAs($user);
        
        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        $this->delete('/api/comments/' . $comment->id);
        
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}

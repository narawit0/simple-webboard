<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function comment_belongsTo_post() {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf('App\Post', $comment->post);
    }

    /** @test */
    public function comment_belongsTo_user() {
        $comment = factory('App\Comment')->create();
        
        $this->assertInstanceOf('App\User', $comment->user);
    }
}

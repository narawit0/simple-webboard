<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_post_belong_to_channel() {
        $post = factory('App\Post')->create();

        $this->assertInstanceOf('App\Channel', $post->channel);
    }

    /** @test */
    public function a_post_has_many_comments() {
        $post = factory('App\Post')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $post->comments);
    }

    /** @test */

    public function a_post_belong_to_user() {
        $post = factory('App\Post')->create();

        $this->assertInstanceOf('App\User', $post->user);
    }
}

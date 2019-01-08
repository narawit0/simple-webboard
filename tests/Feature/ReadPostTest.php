<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadPost extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_user_can_read_all_posts() {
       $post = factory('App\Post')->create();

       $this->get('/api/posts')
            ->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->body);
   }

   /** @test */
   public function a_user_can_read_post_by_id() {
       $post = factory('App\Post')->create();

       $this->get('/api/posts/' . $post->id)
            ->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->body);
   }

   /** @test */
   public function a_user_can_read_post_by_channel() {
       $channel = factory('App\Channel')->create();
       $post = factory('App\Post')->create(['channel_id' => $channel->id]);


       $this->get('/api/posts/channels/' . $channel->title)
            ->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->body);
   }
}

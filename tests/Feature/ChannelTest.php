<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function can_get_channels() {
        $channels = factory('App\Channel', 4)->create();

        $this->get('/api/channels')
             ->assertStatus(200)
             ->assertJson([
                 'channels' => $channels->toArray()
             ]);
    }
}

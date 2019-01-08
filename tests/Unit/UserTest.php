<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp() {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }

    /** @test */
    public function user_has_many_posts() {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->posts);
    }

    /** @test */
    public function user_has_many_comments() {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->comments);
    }
}

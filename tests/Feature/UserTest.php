<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_register() {

        $user = [
            'name' => 'Narawit kaewbun',
            'email' => 'narawit.kaewbun@gmail.com',
            'password' => '123456',
            'confirm_password' => '123456'
        ];


        $response = $this->post('/api/auth/register', $user);

        array_splice($user,2, 2);

        $this->assertDatabaseHas('users', $user);
    }

    /** @test */ 
    public function a_user_can_login() {
        factory('App\User')->create([
            'email' => 'test@gmail.com',
            'password' => 'secret'
        ]);

        $userLogin = [
            'email' => 'test@gmail.com',
            'password' => 'secret'
        ];

        $this->post('/api/auth/login', $userLogin)
             ->assertStatus(200)
             ->assertJson([
                 'message' => 'ok'
             ]);

    }
}

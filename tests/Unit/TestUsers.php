<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestUsers extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_creating_user()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->text,
        ];

        $this->post(route('users.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\JWTAuth;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function user_cannot_create_product_if_unauthenticated()
    {
        $data = [
            'name' => "New Product",
            'description' => "This is a product",
            'quantity' => 20,
        ];

        $response = $this->json('POST', '/api/v1/products', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Please, attach a Bearer Token to your request"]);
    }
    public function testCreateProduct()
    {
        $data = [
            'name' => "New Product",
            'description' => "This is a product",
            'quantity' => 20,
        ];
        $user = factory(\App\User::class)->create();
        // create valid token
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);;
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/v1/products',
            $data,
            ['Authorization' => "Bearer $token"]
        );
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
        $response->assertJson(['message' => "successfully inserted an new product"]);
        $response->assertJson(['data' => $data]);
    }
}

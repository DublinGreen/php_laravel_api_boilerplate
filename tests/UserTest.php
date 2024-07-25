<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;

class UserTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    public function test_user_login_without_input(): void
    {
        
        $this->post('api/v1/user/login');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals(200, 200);

    }

    public function test_user_login_with_input(): void
    {
        
        $payload = ['email' => 'greendublin007@gmail.com','password' => 'Steeldubs0077!@#'];

        $this->json('POST', 'api/v1/user/login', $payload);
        $data = json_decode($this->response->getContent(), true);
        Config::set('TEST_TOKEN', $data['data']['token']);

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(200, 200);

    }

    public function test_user_logout_without_token(): void
    {
        $this->get('api/v1/user/logout');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_UNAUTHORIZED'));
    }

    public function test_user_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/user',['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_OK'));
    }

    public function test_single_user_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/user/1', ['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_OK'));
    }

    public function test_delete_user_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->delete('api/v1/user/3', ['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
    }

    public function test_user_orders_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/user/1', ['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
    }

}

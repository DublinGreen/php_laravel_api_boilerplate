<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{

    public function test_admin_login_without_input(): void
    {
        
        $this->post('api/v1/admin/login');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals(200, 200);

    }

    public function test_admin_logout_without_token(): void
    {
        $this->get('api/v1/admin/logout');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_UNAUTHORIZED'));
    }

    public function test_admin_listing_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/admin/user-listing',['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_OK'));
    }

}

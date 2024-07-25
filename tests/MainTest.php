<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MainTest extends TestCase
{

    public function test_main_blog_without_token(): void
    {
        $this->get('api/v1/main/blog');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_UNAUTHORIZED'));
    }

    public function test_main_blog_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/main/blog',['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_OK'));
    }

    public function test_main_promotions_without_token(): void
    {
        $this->get('api/v1/main/promotions');
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_UNAUTHORIZED'));
    }

    public function test_main_promotions_with_token(): void
    {
        $token = env('TEST_TOKEN');
        $this->get('api/v1/main/promotions',['Authorization' => 'Bearer ' . $token]);
        $data = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals($data['statusCode'], env('HTTP_SERVER_CODE_OK'));
    }

}

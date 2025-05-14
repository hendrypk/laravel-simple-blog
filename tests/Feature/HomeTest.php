<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_page_contains_welcome_text(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Home');
    }
}

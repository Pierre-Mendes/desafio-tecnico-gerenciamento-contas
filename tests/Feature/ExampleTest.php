<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_error_404(): void
    {
        $response = $this->get('/aaaa');

        $response->assertStatus(404);
    }
}

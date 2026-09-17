<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_palestine_pricing_uses_fixed_subject_prices(): void
    {
        $response = $this->get('/pricing?region=palestine');

        $response->assertStatus(200)
            ->assertSee('80')
            ->assertSee('100')
            ->assertSee('غزة والضفة')
            ->assertDontSee('مواد متاحة حاليًا');
    }
}

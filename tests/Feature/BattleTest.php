<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Validates the end-to-end flow of the Battle application via HTTP requests.
 */
class BattleTest extends TestCase
{
    /**
     * Trait that ensures the test database is completely reset after every single test.
     * This prevents test data from leaking into your real database.
     */
    use RefreshDatabase;

    /**
     * Ensures that accessing the start battle route executes the simulation,
     * saves it to the database, and renders the result view.
     */
    public function test_user_can_start_and_view_a_new_battle(): void
    {
        // Act: Simulate a GET request to the battle start route from a web browser
        $response = $this->get(route('battle.start'));

        // Assert: Check if the server responded successfully (HTTP 200 OK)
        $response->assertStatus(200);

        // Assert: Check if the correct HTML view was returned
        $response->assertViewIs('battle.show');

        // Assert: Check if the 'battle' variable was passed to the view
        $response->assertViewHas('battle');

        // Assert: Verify that exactly one record was actually saved in the 'battles' table
        $this->assertDatabaseCount('battles', 1);
    }

    /**
     * Ensures the history page loads correctly and receives the past battles.
     */
    public function test_user_can_view_battle_history(): void
    {
        // Act: Simulate a GET request to the history route
        $response = $this->get(route('battle.index'));

        // Assert: Check if the server responded successfully
        $response->assertStatus(200);

        // Assert: Check if the correct view was returned
        $response->assertViewIs('battle.index');

        // Assert: Check if the 'battles' collection was passed to the view
        $response->assertViewHas('battles');
    }
}

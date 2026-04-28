<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entities\Hero;
use PHPUnit\Framework\TestCase;

/**
 * Validates the fundamental combat mechanics shared by all fighters.
 */
class FighterTest extends TestCase
{
    /**
     * Ensures standard damage subtraction works accurately.
     */
    public function test_fighter_health_decreases_when_taking_damage(): void
    {
        // Arrange: Initialize a Hero with 100 Health
        $hero = new Hero('Kratos', 100, 80, 50, 45, 0.15);

        // Act: Apply 30 damage
        $hero->takeDamage(30);

        // Assert: Health should be exactly 70
        $this->assertEquals(70, $hero->getHealth());
        $this->assertTrue($hero->isAlive());
    }

    /**
     * Edge Case: Prevents health from dropping into negative values.
     */
    public function test_health_floor_is_zero(): void
    {
        // Arrange
        $hero = new Hero('Kratos', 40, 80, 50, 45, 0.15);

        // Act: Apply fatal damage exceeding current health
        $hero->takeDamage(100);

        // Assert: Health stops at 0, fighter is dead
        $this->assertEquals(0, $hero->getHealth());
        $this->assertFalse($hero->isAlive());
    }

    /**
     * Edge Case: Negative damage (e.g., from buffs) must not heal the fighter.
     */
    public function test_negative_damage_is_ignored(): void
    {
        // Arrange
        $hero = new Hero('Kratos', 80, 80, 50, 45, 0.15);

        // Act: Apply negative damage
        $hero->takeDamage(-20);

        // Assert: Health remains unchanged
        $this->assertEquals(80, $hero->getHealth());
    }
}

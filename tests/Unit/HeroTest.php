<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entities\Hero;
use PHPUnit\Framework\TestCase;

/**
 * Validates the core health and damage mechanics of the Hero entity.
 */
class HeroTest extends TestCase
{
    /**
     * Ensures standard damage subtraction works as intended.
     */
    public function test_hero_takes_valid_damage(): void
    {
        // 1. Arrange: Set up the initial state
        $hero = new Hero('Kratos', 100, 80, 50, 45, 0.15);

        // 2. Act: Perform the action being tested
        $hero->takeDamage(30);

        // 3. Assert: Verify the expected outcome
        $this->assertEquals(70, $hero->getHealth());
    }

    /**
     * Edge Case: Health should never be a negative number.
     */
    public function test_health_never_drops_below_zero(): void
    {
        // Arrange
        $hero = new Hero('Kratos', 50, 80, 50, 45, 0.15);

        // Act: Apply massive damage
        $hero->takeDamage(100);

        // Assert
        $this->assertEquals(0, $hero->getHealth());
        $this->assertFalse($hero->isAlive());
    }
}

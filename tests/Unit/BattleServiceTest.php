<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entities\Hero;
use App\Domain\Entities\Monster;
use App\Repository\BattleRepositoryInterface;
use App\Service\BattleService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Validates the core simulation engine and rule enforcement.
 */
class BattleServiceTest extends TestCase
{
    private BattleService $battleService;
    private MockObject $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a fake Repository so we don't hit the real Database
        $this->repositoryMock = $this->createMock(BattleRepositoryInterface::class);
        $this->battleService = new BattleService($this->repositoryMock);
    }

    /**
     * Validates that the repository is called and a winner is declared if someone dies.
     */
    public function test_simulation_ends_with_a_winner_when_health_depletes(): void
    {
        // Arrange: Hero is extremely overpowered, Monster is very weak
        $hero = new Hero('Kratos', 100, 500, 50, 60, 0.0);
        $monster = new Monster('Slime', 10, 5, 5, 10, 0.0);

        // Expect the save method to be called exactly once
        $this->repositoryMock->expects($this->once())->method('save');

        // Act
        $battle = $this->battleService->simulate($hero, $monster);

        // Assert
        $this->assertEquals('Kratos', $battle->getWinnerName());
        $this->assertLessThanOrEqual(15, $battle->getRoundsTotal());
    }

    /**
     * Edge Case: Validates the 15-round limit rule resulting in a draw.
     */
    public function test_simulation_ends_in_a_draw_after_max_rounds(): void
    {
        // Arrange: Both fighters have zero strength, incapable of doing damage
        $hero = new Hero('Kratos', 100, 0, 100, 50, 0.0);
        $monster = new Monster('Golem', 100, 0, 100, 50, 0.0);

        // Expect the repository to still save the battle history
        $this->repositoryMock->expects($this->once())->method('save');

        // Act
        $battle = $this->battleService->simulate($hero, $monster);

        // Assert
        $this->assertEquals('Draw', $battle->getWinnerName());
        $this->assertEquals(15, $battle->getRoundsTotal());
    }
}

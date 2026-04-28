<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entities\Hero;
use App\Domain\Entities\Monster;
use App\Domain\Factories\CharacterFactory;
use App\Domain\Skills\MagicArmourSkill;
use App\Domain\Skills\RapidFireSkill;
use PHPUnit\Framework\TestCase;

/**
 * Validates that character generation adheres strictly to the defined stat boundaries.
 */
class CharacterFactoryTest extends TestCase
{
    private CharacterFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new CharacterFactory();
    }

    /**
     * Ensures Kratos is generated with stats within his specific ranges and has his skills.
     */
    public function test_creates_kratos_with_valid_stats_and_skills(): void
    {
        $kratos = $this->factory->createKratos();

        $this->assertInstanceOf(Hero::class, $kratos);
        $this->assertEquals('Kratos', $kratos->getName());

        // Validate stats boundaries
        $this->assertGreaterThanOrEqual(65, $kratos->getHealth());
        $this->assertLessThanOrEqual(100, $kratos->getHealth());

        $this->assertGreaterThanOrEqual(75, $kratos->getStrength());
        $this->assertLessThanOrEqual(90, $kratos->getStrength());

        $this->assertGreaterThanOrEqual(40, $kratos->getDefence());
        $this->assertLessThanOrEqual(50, $kratos->getDefence());

        $this->assertGreaterThanOrEqual(40, $kratos->getSpeed());
        $this->assertLessThanOrEqual(50, $kratos->getSpeed());

        $this->assertGreaterThanOrEqual(0.10, $kratos->getLuck());
        $this->assertLessThanOrEqual(0.20, $kratos->getLuck());

        // Validate skills assignment
        $this->assertCount(2, $kratos->getSkills());
    }

    /**
     * Ensures the Wild Monster is generated with stats within its specific ranges.
     */
    public function test_creates_wild_monster_with_valid_stats(): void
    {
        $monster = $this->factory->createWildMonster();

        $this->assertInstanceOf(Monster::class, $monster);
        $this->assertEquals('Wild Monster', $monster->getName());

        // Validate stats boundaries
        $this->assertGreaterThanOrEqual(50, $monster->getHealth());
        $this->assertLessThanOrEqual(80, $monster->getHealth());

        $this->assertGreaterThanOrEqual(55, $monster->getStrength());
        $this->assertLessThanOrEqual(80, $monster->getStrength());

        $this->assertGreaterThanOrEqual(50, $monster->getDefence());
        $this->assertLessThanOrEqual(70, $monster->getDefence());

        $this->assertGreaterThanOrEqual(40, $monster->getSpeed());
        $this->assertLessThanOrEqual(60, $monster->getSpeed());

        $this->assertGreaterThanOrEqual(0.30, $monster->getLuck());
        $this->assertLessThanOrEqual(0.45, $monster->getLuck());
    }
}

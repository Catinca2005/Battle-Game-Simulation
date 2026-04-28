<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Skills\MagicArmourSkill;
use App\Domain\Skills\RapidFireSkill;
use PHPUnit\Framework\TestCase;

/**
 * Validates the configuration and probability bounds of combat skills.
 */
class SkillTest extends TestCase
{
    public function test_rapid_fire_has_correct_attributes(): void
    {
        $skill = new RapidFireSkill();

        $this->assertEquals('Rapid Fire', $skill->getName());
        $this->assertEquals(0.15, $skill->getChance());
    }

    public function test_magic_armour_has_correct_attributes(): void
    {
        $skill = new MagicArmourSkill();

        $this->assertEquals('Magic Armour', $skill->getName());
        $this->assertEquals(0.15, $skill->getChance());
    }
}

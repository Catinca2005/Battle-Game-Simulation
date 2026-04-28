<?php

declare(strict_types=1);

namespace App\Domain\Skills;

class MagicArmourSkill implements SkillInterface
{
    public function getName(): string
    {
        return 'Magic Armour';
    }

    public function getChance(): float
    {
        return 0.15; // 15% chance
    }

    public function triggers(): bool
    {
        return (rand(1, 100) / 100) <= $this->getChance();
    }
}

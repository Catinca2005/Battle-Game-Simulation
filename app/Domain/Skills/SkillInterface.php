<?php

declare(strict_types=1);

namespace App\Domain\Skills;

/**
 * Contract for all combat skills.
 */
interface SkillInterface
{
    public function getName(): string;

    /**
     * @return float The probability of the skill triggering (0.0 to 1.0).
     */
    public function getChance(): float;

    /**
     * Determines if the skill activates based on its chance.
     */
    public function triggers(): bool;
}

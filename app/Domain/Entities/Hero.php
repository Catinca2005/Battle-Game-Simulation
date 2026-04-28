<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Represents the hero (Kratos), capable of using specialized combat skills.
 */
class Hero extends Fighter
{
    /** List of special skills assigned to the hero. */
    protected array $skills = [];

    public function __construct(
        string $name,
        int $health,
        int $strength,
        int $defence,
        int $speed,
        float $luck,
        ?int $id = null
    ) {
        parent::__construct($name, $health, $strength, $defence, $speed, $luck, $id);
    }

    /**
     * Attaches a new combat skill to the hero.
     */
    public function addSkill($skill): void
    {
        $this->skills[] = $skill;
    }

    /**
     * @return array The collection of active skills for this hero.
     */
    public function getSkills(): array
    {
        return $this->skills;
    }
}

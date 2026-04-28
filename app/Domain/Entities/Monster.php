<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Represents a wild monster encountered in the forest with specific combat stats.
 */
class Monster extends Fighter
{
    /**
     * Initializes a new Monster instance.
     * * @param string $name The display name of the monster.
     * @param int $health Initial health points.
     * @param int $strength Physical attack power.
     * @param int $defence Resistance to incoming damage.
     * @param int $speed Determines turn order in battle.
     * @param float $luck Chance to dodge an attack.
     * @param int|null $id Unique identifier from the database.
     */
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
}

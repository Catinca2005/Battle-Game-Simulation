<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Abstract class representing a combatant, inheriting identity from Entity.
 */
abstract class Fighter extends Entity
{
    public function __construct(
        protected string $name,
        protected int $health,
        protected int $strength,
        protected int $defence,
        protected int $speed,
        protected float $luck,
        ?int $id = null
    ) {
        // We pass the ID to the parent Entity class
        parent::__construct($id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): float
    {
        return $this->luck;
    }

    /**
     * Reduces health by damage points, ensuring health does not drop below zero.
     */
    public function takeDamage(int $damage): void
    {
        // If the defense is greater than the attack we have to attribute 0
        // Bcs if it is negative we would add life
        $effectiveDamage = max(0, $damage);

        // Prevents the health from dropping below zero
        $this->health = max(0, $this->health - $effectiveDamage);
    }

    /**
     * Checks if the fighter still has health points remaining.
     */
    public function isAlive(): bool
    {
        return $this->health > 0;
    }
}

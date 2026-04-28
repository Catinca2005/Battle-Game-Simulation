<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Entities\Battle;
use App\Domain\Entities\Fighter;

/**
 * Defines the core requirements for the combat simulation engine.
 */
interface BattleServiceInterface
{
    /**
     * Executes a full turn-based combat simulation between two fighters.
     *
     * @param Fighter $hero The protagonist of the battle.
     * @param Fighter $monster The antagonist encountered.
     * @return Battle The finalized battle record including logs and winner.
     */
    public function simulate(Fighter $hero, Fighter $monster): Battle;

    /**
     * Retrieves all past battle simulations.
     *
     * @return Battle[] A collection of historical battle records.
     */
    public function getBattleHistory(): array;

    /**
     * Retrieves a specific battle record by its unique identifier.
     *
     * @param int $id The unique ID of the battle record.
     * @return Battle|null The battle record if found, null otherwise.
     */
    public function getBattleById(int $id): ?Battle;
}

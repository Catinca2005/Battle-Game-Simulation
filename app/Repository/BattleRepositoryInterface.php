<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entities\Battle;

/**
 * Contract for battle persistence, ensuring the Domain remains decoupled from the database.
 */
interface BattleRepositoryInterface
{
    /**
     * Persists a new battle record to the storage.
     * * @param Battle $battle The battle entity to be saved.
     */
    public function save(Battle $battle): void;

    /**
     * Retrieves a specific battle history by its unique identifier.
     * * @param int $id The database ID of the battle.
     * @return Battle|null Returns the Battle entity if found, or null otherwise.
     */
    public function findById(int $id): ?Battle;

    /**
     * Retrieves all recorded battles.
     * * @return Battle[] An array of Battle entities.
     */
    public function findAll(): array;
}

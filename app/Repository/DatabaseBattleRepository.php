<?php

namespace App\Repository;

use App\Domain\Entities\Battle;
use Illuminate\Support\Facades\DB;

/**
 * Concrete implementation of the BattleRepository using Laravel's Query Builder.
 * Handles the translation between Domain Entities and SQLite Database records.
 */
class DatabaseBattleRepository implements BattleRepositoryInterface
{
    private const TABLE_NAME = 'battles';

    public function save(Battle $battle): void
    {
        // 1. Prepare data for database insertion
        // We use JSON_encode because SQLite stores the log array as a TEXT column
        $data = [
            'hero_name'    => $battle->getHeroName(),
            'monster_name' => $battle->getMonsterName(),
            'winner_name'  => $battle->getWinnerName(),
            'rounds_total' => $battle->getRoundsTotal(),
            'log'          => json_encode($battle->getLog()),
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        // 2. Insert into database and retrieve the newly generated ID
        $insertedId = DB::table(self::TABLE_NAME)->insertGetId($data);

        // 3. Update the Domain Entity with its new database identity
        $battle->setId($insertedId);
    }

    public function findById(int $id): ?Battle
    {
        $record = DB::table(self::TABLE_NAME)->find($id);

        if (!$record) {
            return null; // Battle not found in the database
        }

        return $this->mapToEntity($record);
    }

    public function findAll(): array
    {
        $records = DB::table(self::TABLE_NAME)->get();
        $battles = [];

        foreach ($records as $record) {
            $battles[] = $this->mapToEntity($record);
        }

        return $battles;
    }

    /**
     * Helper Method: Maps a raw database record object to a pure Domain Battle Entity.
     * * @param object $record The raw object retrieved from the database.
     * @return Battle The reconstructed Domain entity.
     */
    private function mapToEntity(object $record): Battle
    {
        // Decode the JSON text back into a PHP array for the log property
        $logArray = json_decode($record->log, true) ?? [];

        return new Battle(
            $record->hero_name,
            $record->monster_name,
            $record->winner_name,
            (int) $record->rounds_total,
            $logArray,
            (int) $record->id
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Represents a single battle simulation record.
 */
class Battle extends Entity
{
    public function __construct(
        protected string $heroName,
        protected string $monsterName,
        protected ?string $winnerName = null,
        protected int $roundsTotal = 0,
        protected array $log = [], // We save what happend in every round
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getHeroName(): string
    {
        return $this->heroName;
    }

    public function getMonsterName(): string
    {
        return $this->monsterName;
    }

    public function getWinnerName(): ?string
    {
        return $this->winnerName;
    }

    public function getRoundsTotal(): int
    {
        return $this->roundsTotal;
    }

    public function getLog(): array
    {
        return $this->log;
    }

   /**
    * Method that adds a new information line in the jurnal of the battle
    */
    public function addLogEntry(string $message): void
    {
        $this->log[] = $message;
    }

    public function setWinner(string $winnerName, int $rounds): void
    {
        $this->winnerName = $winnerName;
        $this->roundsTotal = $rounds;
    }
}

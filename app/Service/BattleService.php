<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Entities\Battle;
use App\Domain\Entities\Fighter;
use App\Domain\Entities\Hero;
use App\Repository\BattleRepositoryInterface;
use App\Domain\Skills\MagicArmourSkill;
use App\Domain\Skills\RapidFireSkill;

/**
 * Core domain service handling the business logic for a battle simulation.
 */
class BattleService implements BattleServiceInterface
{
    private const MAX_ROUNDS = 15;

    /**
     * Injects the repository contract to save battle history.
     */
    public function __construct(
        private BattleRepositoryInterface $battleRepository
    ) {
    }

    public function simulate(Fighter $hero, Fighter $monster): Battle
    {
        $battle = new Battle($hero->getName(), $monster->getName());

        $attacker = $this->determineFirstAttacker($hero, $monster);
        $defender = ($attacker === $hero) ? $monster : $hero;

        $battle->addLogEntry("Battle started! {$attacker->getName()} has the initiative.");

        for ($round = 1; $round <= self::MAX_ROUNDS; $round++) {
            $battle->addLogEntry("--- Round {$round} ---");

            $this->executeTurn($attacker, $defender, $battle);

            // Check if the battle is over
            if (!$defender->isAlive() || !$attacker->isAlive()) {
                $winner = $hero->isAlive() ? $hero->getName() : $monster->getName();
                $battle->setWinner($winner, $round);
                $battle->addLogEntry("{$winner} won the battle!");
                break;
            }

            // Switch roles for the next turn
            [$attacker, $defender] = [$defender, $attacker];
        }

        // Handle the case where max rounds are reached without a clear winner
        if (!$battle->getWinnerName()) {
            $battle->setWinner('Draw', self::MAX_ROUNDS);
            $battle->addLogEntry("The battle ended in a draw after 15 rounds.");
        }

        // Persist the battle history
        $this->battleRepository->save($battle);

        return $battle;
    }

    public function getBattleHistory(): array
    {
        return $this->battleRepository->findAll();
    }

    public function getBattleById(int $id): ?Battle
    {
        return $this->battleRepository->findById($id);
    }

    /**
     * Determines which fighter attacks first based on speed and luck.
     */
    private function determineFirstAttacker(Fighter $hero, Fighter $monster): Fighter
    {
        if ($hero->getSpeed() !== $monster->getSpeed()) {
            return ($hero->getSpeed() > $monster->getSpeed()) ? $hero : $monster;
        }

        // Tie-breaker based on luck
        return ($hero->getLuck() > $monster->getLuck()) ? $hero : $monster;
    }

    /**
     * Executes the attack logic for a single round, including skills and luck.
     */
    private function executeTurn(Fighter $attacker, Fighter $defender, Battle $battle): void
    {
        $attacksThisTurn = 1;

        // Check for attacker offensive skills (Rapid Fire)
        if ($attacker instanceof Hero) {
            foreach ($attacker->getSkills() as $skill) {
                if ($skill instanceof RapidFireSkill && $skill->triggers()) {
                    $attacksThisTurn = 2;
                    $battle->addLogEntry("{$attacker->getName()} activates {$skill->getName()}! Striking twice.");
                }
            }
        }

        for ($i = 1; $i <= $attacksThisTurn; $i++) {
            if (!$defender->isAlive()) {
                break;
            }

            if ($attacksThisTurn > 1) {
                $battle->addLogEntry("Strike {$i}:");
            }

            // Check if defender dodges
            if ($this->isLucky($defender)) {
                $battle->addLogEntry("{$defender->getName()} gets lucky and dodges the attack! 0 damage taken.");
                continue;
            }

            $this->processDamage($attacker, $defender, $battle);
        }
    }

    /**
     * Calculates and applies damage, factoring in defensive skills.
     */
    private function processDamage(Fighter $attacker, Fighter $defender, Battle $battle): void
    {
        $baseDamage = $attacker->getStrength() - $defender->getDefence();
        $finalDamage = max(0, $baseDamage);

        // Check for defender defensive skills (e.g., Magic Armour)
        if ($defender instanceof Hero) {
            foreach ($defender->getSkills() as $skill) {
                if ($skill instanceof MagicArmourSkill && $skill->triggers()) {
                    $finalDamage = (int) ($finalDamage / 2);
                    $battle->addLogEntry("{$defender->getName()} activates {$skill->getName()}! Damage halved.");
                }
            }
        }

        $defender->takeDamage($finalDamage);

        $battle->addLogEntry("{$attacker->getName()} deals {$finalDamage} damage.");
        $battle->addLogEntry("{$defender->getName()}'s health left: {$defender->getHealth()}.");
    }

    /**
     * Checks if a fighter successfully triggers their luck mechanic.
     */
    private function isLucky(Fighter $fighter): bool
    {
        $chance = $fighter->getLuck();
        $roll = rand(1, 100) / 100;

        return $roll <= $chance;
    }
}

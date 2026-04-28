<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Entities\Hero;
use App\Domain\Entities\Monster;
use App\Domain\Skills\MagicArmourSkill;
use App\Domain\Skills\RapidFireSkill;

/**
 * Factory class to generate fighters with randomized base stats.
 */
class CharacterFactory
{
    /**
     * Instantiates Kratos with stats within his specific ranges.
     */
    public function createKratos(): Hero
    {
        $hero = new Hero(
            name: 'Kratos',
            health: rand(65, 100),
            strength: rand(75, 90),
            defence: rand(40, 50),
            speed: rand(40, 50),
            luck: rand(10, 20) / 100
        );

        $hero->addSkill(new RapidFireSkill());
        $hero->addSkill(new MagicArmourSkill());

        return $hero;
    }

    /**
     * Instantiates a Wild Monster with stats within its specific ranges.
     */
    public function createWildMonster(): Monster
    {
        return new Monster(
            name: 'Wild Monster',
            health: rand(50, 80),
            strength: rand(55, 80),
            defence: rand(50, 70),
            speed: rand(40, 60),
            luck: rand(30, 45) / 100
        );
    }
}

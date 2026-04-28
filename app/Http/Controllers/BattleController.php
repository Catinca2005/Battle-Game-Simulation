<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Factories\CharacterFactory;
use App\Service\BattleServiceInterface;
use Illuminate\View\View;

class BattleController extends Controller
{
    public function __construct(
        private CharacterFactory $characterFactory,
        private BattleServiceInterface $battleService
    ) {}

    public function start(): View
    {
        $hero = $this->characterFactory->createKratos();
        $monster = $this->characterFactory->createWildMonster();

        // Salvăm viața inițială pentru animația barelor (înainte să înceapă lupta)
        $kratosInitialHp = $hero->getHealth();
        $monsterInitialHp = $monster->getHealth();

        $battle = $this->battleService->simulate($hero, $monster);

        return view('battle.show', [
            'battle' => $battle,
            'kratosInitialHp' => $kratosInitialHp,
            'monsterInitialHp' => $monsterInitialHp
        ]);
    }

    public function index(): View
    {
        $battles = $this->battleService->getBattleHistory();

        return view('battle.index', ['battles' => $battles]);
    }
}

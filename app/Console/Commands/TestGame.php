<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Factories\CharacterFactory;

class TestGame extends Command
{
    // The name of the command you will type in terminal
    protected $signature = 'game:test';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Displays a welcome message';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Welcome! Good luck with the battle application!');
    }
}

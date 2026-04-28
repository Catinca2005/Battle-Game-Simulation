<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Battle Sim 8-Bit</title>

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#b19cd9",
                        "on-primary-fixed": "#220f44",
                        "tertiary": "#f1c100",
                        "error": "#ffb4ab",
                        "surface-container-lowest": "#0c0f0f",
                        "surface-variant": "#333535",
                        "primary": "#d2bcfb",
                        "on-primary": "#38265b",
                        "background": "#121414"
                    },
                    fontFamily: {
                        "space": ["Space Grotesk", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <style>
        /* Base styles and custom scrollbar */
        body { font-family: 'Space Grotesk', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 16px; }
        ::-webkit-scrollbar-track { background: #121414; border-left: 4px solid #000; }
        ::-webkit-scrollbar-thumb { background: #b19cd9; border: 4px solid #000; }

        /* Smooth transition for HP bars */
        .health-transition { transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Animation Keyframes */
        .sprite { transition: transform 0.2s ease; image-rendering: pixelated; }

        @keyframes attack-right {
            0% { transform: translateX(0); }
            50% { transform: translateX(60px) scale(1.1); }
            100% { transform: translateX(0); }
        }

        @keyframes attack-left {
            0% { transform: translateX(0); }
            50% { transform: translateX(-60px) scale(1.1); }
            100% { transform: translateX(0); }
        }

        @keyframes take-hit {
            0% { filter: brightness(1); transform: translateX(0); }
            25% { filter: brightness(2) drop-shadow(0 0 15px red) invert(1); transform: translateX(-10px); }
            50% { filter: brightness(1) drop-shadow(0 0 15px red); transform: translateX(10px); }
            100% { filter: brightness(1); transform: translateX(0); }
        }

        @keyframes fly-right {
            0% { transform: translateX(-150px); opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { transform: translateX(150px); opacity: 0; }
        }

        @keyframes fly-left {
            0% { transform: translateX(150px); opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { transform: translateX(-150px); opacity: 0; }
        }

        /* Animation Utility Classes */
        .anim-attack-hero { animation: attack-right 0.5s forwards; }
        .anim-attack-monster { animation: attack-left 0.5s forwards; }
        .anim-hit { animation: take-hit 0.5s forwards; }
        .anim-arrow-right { animation: fly-right 0.6s forwards; }
        .anim-arrow-left { animation: fly-left 0.6s forwards; }
    </style>
</head>

<body class="bg-background text-white min-h-screen flex flex-col uppercase font-bold tracking-tighter">

<header class="w-full bg-slate-900 text-primary border-b-4 border-black shadow-[0_4px_0_0_rgba(0,0,0,1)] flex justify-center items-center h-16 mb-8">
    <div class="text-2xl border-4 border-black px-4 py-1 bg-slate-800 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        BATTLE SIM 8-BIT
    </div>
</header>

<main class="flex-grow px-4 flex flex-col gap-8 max-w-[1200px] mx-auto w-full pb-12">

    <section class="relative w-full h-80 md:h-96 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-surface-container-highest overflow-hidden">

        <div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/forest.png') }}'); opacity: 0.6;"></div>

        <div class="absolute inset-0 w-full h-full flex justify-between items-end p-4 md:p-8 z-10">

            <div class="flex flex-col items-center gap-4 w-1/3 z-20">
                <div class="w-full bg-primary-container border-4 border-black p-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="text-on-primary-fixed text-center text-xl md:text-2xl mb-1">KRATOS</div>
                    <div id="hero-hp-text" class="text-on-primary-fixed text-center text-sm mb-2 tracking-widest">HP: {{ $kratosInitialHp }}/{{ $kratosInitialHp }}</div>
                    <div class="w-full h-4 border-2 border-black bg-surface-container-lowest p-0.5">
                        <div id="hero-hp-bar" class="h-full bg-green-500 border-r-2 border-black health-transition" style="width: 100%;"></div>
                    </div>
                </div>
                <img id="hero-sprite" src="{{ asset('images/hero.gif') }}" alt="Kratos" class="h-32 md:h-48 sprite drop-shadow-[0_10px_10px_rgba(0,0,0,0.8)]">
            </div>

            <div id="attack-container" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none opacity-0 z-30">
                <div id="damage-text" class="bg-black border-4 border-error text-error text-2xl md:text-4xl px-4 py-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] mb-4 hidden">-0 DMG</div>
                <div id="attack-arrow" class="text-white text-6xl drop-shadow-[4px_4px_0_rgba(0,0,0,1)] hidden">➔</div>
            </div>

            <div class="flex flex-col items-center gap-4 w-1/3 z-20">
                <div class="w-full bg-surface-variant border-4 border-black p-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="text-white text-center text-xl md:text-2xl mb-1">WILD MONSTER</div>
                    <div id="monster-hp-text" class="text-white text-center text-sm mb-2 tracking-widest">HP: {{ $monsterInitialHp }}/{{ $monsterInitialHp }}</div>
                    <div class="w-full h-4 border-2 border-black bg-surface-container-lowest p-0.5">
                        <div id="monster-hp-bar" class="h-full bg-error border-r-2 border-black health-transition" style="width: 100%;"></div>
                    </div>
                </div>
                <img id="monster-sprite" src="{{ asset('images/monster.gif') }}" alt="Monster" class="h-32 md:h-48 sprite drop-shadow-[0_10px_10px_rgba(0,0,0,0.8)]">
            </div>
        </div>
    </section>

    <section class="w-full border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-primary-container flex flex-col h-72">
        <div class="bg-on-primary-fixed text-primary-container px-4 py-3 border-b-4 border-black flex justify-between items-center text-lg">
            <span>COMBAT LOG</span>
            <span class="material-symbols-outlined text-xl">history</span>
        </div>

        <div id="scroll-box" class="flex-grow p-4 m-4 border-4 border-black bg-on-primary-fixed overflow-y-auto text-white shadow-[inset_4px_4px_0px_0px_rgba(0,0,0,0.5)]">
            <ul id="battle-log-list" class="space-y-3 text-sm md:text-base tracking-wide">
                <li id="winner-banner" class="text-tertiary font-black text-lg mb-4 hidden">> BATTLE ENDED: {{ $battle->getWinnerName() }} WON!</li>
            </ul>
        </div>
    </section>

    <section id="action-buttons" class="flex flex-col md:flex-row gap-8 justify-center w-full opacity-0 pointer-events-none transition-opacity duration-1000">
        <a href="{{ route('battle.start') }}" class="flex-1 bg-primary border-4 border-black p-4 text-on-primary shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:bg-white active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all text-xl md:text-2xl flex items-center justify-center gap-4">
            <span class="material-symbols-outlined text-3xl">swords</span>
            SIMULATE NEW BATTLE
        </a>
        <a href="{{ route('battle.index') }}" class="flex-1 bg-surface-variant border-4 border-black p-4 text-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:bg-black active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all text-xl md:text-2xl flex items-center justify-center gap-4">
            <span class="material-symbols-outlined text-3xl">menu_book</span>
            VIEW HISTORY
        </a>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', async function() {

        // Initialization Data mapped from backend
        const logs = @json($battle->getLog());
        const maxHp = {
            hero: {{ $kratosInitialHp }},
            monster: {{ $monsterInitialHp }}
        };

        // DOM Selectors
        const UI = {
            logList: document.getElementById('battle-log-list'),
            scrollBox: document.getElementById('scroll-box'),
            hero: {
                sprite: document.getElementById('hero-sprite'),
                hpBar: document.getElementById('hero-hp-bar'),
                hpText: document.getElementById('hero-hp-text')
            },
            monster: {
                sprite: document.getElementById('monster-sprite'),
                hpBar: document.getElementById('monster-hp-bar'),
                hpText: document.getElementById('monster-hp-text')
            },
            fx: {
                container: document.getElementById('attack-container'),
                arrow: document.getElementById('attack-arrow'),
                damageText: document.getElementById('damage-text')
            },
            endGame: {
                banner: document.getElementById('winner-banner'),
                buttons: document.getElementById('action-buttons')
            }
        };

        // Helper: Pause Execution
        const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));

        // Helper: Print log to Combat Window
        const appendLog = (text, type = 'normal') => {
            const li = document.createElement('li');
            li.innerText = `> ${text}`;

            // Color coding based on event type
            if (type === 'damage') {
                li.classList.add('text-error', 'font-bold');
            } else if (type === 'dodge' || type === 'skill') {
                li.classList.add('text-tertiary');
            } else {
                li.classList.add('opacity-80');
            }

            UI.logList.appendChild(li);
            UI.scrollBox.scrollTop = UI.scrollBox.scrollHeight;
        };

        // Helper: Refresh Health Bar UI
        const updateHealthUI = (target, currentHp) => {
            const percent = Math.max(0, (currentHp / maxHp[target]) * 100);

            UI[target].hpText.innerText = `HP: ${currentHp}/${maxHp[target]}`;
            UI[target].hpBar.style.width = `${percent}%`;

            if (percent <= 30) {
                UI[target].hpBar.style.backgroundColor = '#ffb4ab'; // Error red
            } else if (percent <= 60) {
                UI[target].hpBar.style.backgroundColor = '#f1c100'; // Warning yellow
            }
        };

        // Helper: Execute Visual Attack
        const playAttackAnimation = async (attacker, damageAmount, isDodge = false) => {
            const defender = attacker === 'hero' ? 'monster' : 'hero';
            const direction = attacker === 'hero' ? 'right' : 'left';
            const arrowChar = attacker === 'hero' ? '➔' : '🡨';

            // Setup visual properties
            UI.fx.arrow.innerText = arrowChar;
            UI.fx.damageText.innerText = isDodge ? 'MISSED!' : `-${damageAmount} DMG`;

            UI.fx.arrow.classList.remove('hidden');
            UI.fx.damageText.classList.remove('hidden');
            UI.fx.container.style.opacity = '1';

            // Trigger movement
            UI[attacker].sprite.classList.add(`anim-attack-${attacker}`);
            UI.fx.arrow.classList.add(`anim-arrow-${direction}`);

            // Wait for impact
            await sleep(300);

            if (!isDodge) {
                UI[defender].sprite.classList.add('anim-hit');
            }

            // Wait for animation completion and reset
            await sleep(500);
            UI[attacker].sprite.classList.remove(`anim-attack-${attacker}`);
            UI[defender].sprite.classList.remove('anim-hit');
            UI.fx.arrow.classList.remove(`anim-arrow-${direction}`);

            UI.fx.container.style.opacity = '0';
            UI.fx.arrow.classList.add('hidden');
            UI.fx.damageText.classList.add('hidden');
        };

        // --- BATTLE SIMULATION ENGINE ---
        for (let i = 0; i < logs.length; i++) {
            const currentLine = logs[i];

            if (currentLine.includes('deals') && currentLine.includes('damage')) {
                const attackerMatch = currentLine.startsWith('Kratos') ? 'hero' : 'monster';
                const damageMatch = currentLine.match(/deals\s+(\d+)\s+damage/);

                if (damageMatch) {
                    appendLog(currentLine, 'damage');
                    await playAttackAnimation(attackerMatch, parseInt(damageMatch[1]), false);
                }
            }
            else if (currentLine.includes('dodges the attack')) {
                const defenderMatch = currentLine.startsWith('Kratos') ? 'hero' : 'monster';
                const attackerMatch = defenderMatch === 'hero' ? 'monster' : 'hero';

                appendLog(currentLine, 'dodge');
                await playAttackAnimation(attackerMatch, 0, true);
            }
            else if (currentLine.includes('activates')) {
                appendLog(currentLine, 'skill');
            }
            else if (currentLine.includes('health left:')) {
                const targetMatch = currentLine.startsWith('Kratos') ? 'hero' : 'monster';
                const hpMatch = currentLine.match(/health left:\s*(\d+)/);

                if (hpMatch) {
                    updateHealthUI(targetMatch, parseInt(hpMatch[1]));
                }
                appendLog(currentLine, 'normal');
            }
            else {
                appendLog(currentLine, 'normal');
            }

            // Pause reading speed
            await sleep(1500);
        }

        // --- END GAME TRIGGER ---
        UI.endGame.banner.classList.remove('hidden');
        UI.endGame.buttons.classList.remove('opacity-0', 'pointer-events-none');
        UI.scrollBox.scrollTop = 0;
    });
</script>
</body>
</html>

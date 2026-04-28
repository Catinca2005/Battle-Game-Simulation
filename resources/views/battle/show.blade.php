<!DOCTYPE html>
<html class="dark" lang="en"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Battle Sim 8-Bit</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#b19cd9",
                        "on-primary-fixed": "#220f44",
                        "tertiary": "#f1c100",
                        "error": "#ffb4ab",
                        "surface-container-lowest": "#0c0f0f",
                        "surface-variant": "#333535",
                        "primary": "#d2bcfb",
                        "on-primary": "#38265b",
                        "on-surface-variant": "#cbc4d0",
                        "surface-container-highest": "#333535",
                        "inverse-primary": "#67558c",
                        "background": "#121414"
                    },
                    "fontFamily": {
                        "headline-md": ["Space Grotesk"],
                        "label-caps": ["Space Grotesk"],
                        "body-lg": ["Space Grotesk"]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 16px; }
        ::-webkit-scrollbar-track { background: #121414; border-left: 4px solid #000; }
        ::-webkit-scrollbar-thumb { background: #b19cd9; border: 4px solid #000; }

        /* Tranzitie lina pentru bara de viata */
        .hp-transition { transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-background text-white font-body-lg min-h-screen flex flex-col selection:bg-primary selection:text-on-primary">

<header class="fixed top-0 w-full z-50 bg-slate-900 text-purple-400 font-['Space_Grotesk'] uppercase font-bold tracking-tighter border-b-4 border-black shadow-[0_4px_0_0_rgba(0,0,0,1)] flex justify-between items-center px-4 h-16 hidden md:flex">
    <div class="text-xl font-black text-purple-400 border-4 border-black px-2 bg-slate-800 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        BATTLE SIM 8-BIT
    </div>
</header>

<main class="flex-grow pt-4 md:pt-24 pb-24 md:pb-8 px-4 flex flex-col gap-8 max-w-[1200px] mx-auto w-full">

    <section class="relative w-full h-64 md:h-96 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-surface-container-highest overflow-hidden">
        <div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-color: #2a1b38; opacity: 0.8;"></div>
        <div class="absolute inset-0 w-full h-full flex justify-between items-end p-4 md:p-8 z-10">

            <div class="flex flex-col items-center gap-4 w-1/3">
                <div class="w-24 h-24 md:w-40 md:h-40 border-4 border-black bg-black flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <span class="material-symbols-outlined text-6xl text-primary">swords</span>
                </div>
                <div class="bg-primary-container border-4 border-black p-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] w-full">
                    <div class="font-headline-md text-black text-center uppercase tracking-tighter text-xl md:text-2xl mb-2">Kratos</div>
                    <div class="w-full h-6 border-2 border-black bg-surface-container-lowest p-0.5 flex">
                        <div id="kratos-hp-bar" class="h-full bg-inverse-primary w-[100%] border-r-2 border-black hp-transition"></div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex bg-tertiary border-4 border-black text-black p-4 font-bold text-2xl shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] self-center -translate-y-8">
                VS
            </div>

            <div class="flex flex-col items-center gap-4 w-1/3">
                <div class="w-24 h-24 md:w-40 md:h-40 border-4 border-black bg-black flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <span class="material-symbols-outlined text-6xl text-error">pest_control</span>
                </div>
                <div class="bg-surface-variant border-4 border-black p-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] w-full">
                    <div class="font-headline-md text-white text-center uppercase tracking-tighter text-xl md:text-2xl mb-2">Wild Monster</div>
                    <div class="w-full h-6 border-2 border-black bg-surface-container-lowest p-0.5 flex">
                        <div id="monster-hp-bar" class="h-full bg-error w-[100%] border-r-2 border-black hp-transition"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-primary-container flex flex-col h-64 md:h-80">
        <div class="bg-black text-primary-container px-4 py-2 border-b-4 border-black font-label-caps flex justify-between items-center">
            <span>COMBAT LOG</span>
            <span class="material-symbols-outlined text-sm">history</span>
        </div>

        <div id="scroll-box" class="flex-grow p-4 m-4 border-4 border-black bg-on-primary-fixed overflow-y-auto font-body-lg text-white shadow-[inset_4px_4px_0px_0px_rgba(0,0,0,0.5)]">
            <ul id="battle-log-list" class="space-y-2">
                <li id="winner-banner" class="text-tertiary font-bold mb-4 hidden">> RESULT: {{ $battle->getWinnerName() }} won in {{ $battle->getRoundsTotal() }} rounds!</li>
            </ul>
        </div>
    </section>

    <section id="action-buttons" class="flex flex-col md:flex-row gap-8 justify-center w-full hidden">
        <a href="{{ route('battle.start') }}" class="flex-1 bg-primary border-4 border-black p-4 font-headline-md text-on-primary uppercase tracking-tighter shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:bg-white active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all duration-75 text-xl md:text-2xl flex items-center justify-center gap-4 text-center">
            <span class="material-symbols-outlined block">swords</span>
            Simulate New Battle
        </a>
        <a href="{{ route('battle.index') }}" class="flex-1 bg-surface-variant border-4 border-black p-4 font-headline-md text-white uppercase tracking-tighter shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:bg-black active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all duration-75 text-xl md:text-2xl flex items-center justify-center gap-4 text-center">
            <span class="material-symbols-outlined block">menu_book</span>
            View History
        </a>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Preluam log-ul din backend sub forma unui array JavaScript
        const logs = @json($battle->getLog());

        const kratosMaxHp = {{ $kratosInitialHp }};
        const monsterMaxHp = {{ $monsterInitialHp }};

        const logContainer = document.getElementById('battle-log-list');
        const scrollBox = document.getElementById('scroll-box');
        const kratosBar = document.getElementById('kratos-hp-bar');
        const monsterBar = document.getElementById('monster-hp-bar');

        // Functia care asteapta (promisiune)
        const sleep = ms => new Promise(r => setTimeout(r, ms));

        // Rulam log-urile unul cate unul
        for (let i = 0; i < logs.length; i++) {
            const logText = logs[i];

            // Cream elementul text
            const li = document.createElement('li');
            li.className = 'opacity-80 mb-2';
            li.innerText = '> ' + logText;
            logContainer.appendChild(li);

            // Auto-scroll mereu in josul casutei mov
            scrollBox.scrollTop = scrollBox.scrollHeight;

            // Daca textul contine o scadere de viata pentru Kratos, extragem numarul din text
            if (logText.includes("Kratos's health left:")) {
                const match = logText.match(/health left:\s*(\d+)/);
                if (match) {
                    let currentHp = parseInt(match[1]);
                    let percent = Math.max(0, (currentHp / kratosMaxHp) * 100);
                    kratosBar.style.width = percent + '%';
                }
            }
            // Daca textul contine viata monstrului, scadem bara acestuia
            else if (logText.includes("Wild Monster's health left:")) {
                const match = logText.match(/health left:\s*(\d+)/);
                if (match) {
                    let currentHp = parseInt(match[1]);
                    let percent = Math.max(0, (currentHp / monsterMaxHp) * 100);
                    monsterBar.style.width = percent + '%';
                }
            }

            // Timpul de asteptare intre lovituri (in milisecunde)
            await sleep(2000);
        }

        // Dupa ce se termina actiunea, afisam titlul de castigator si butoanele
        document.getElementById('winner-banner').classList.remove('hidden');
        document.getElementById('action-buttons').classList.remove('hidden');
        scrollBox.scrollTop = 0; // Dam scroll la inceput sa vedem castigatorul clar
    });
</script>

</body></html>

# ⚔️ Battle Game Simulation

Battle simulation game built with **Laravel (PHP)** and **PostgreSQL**.
Made as a university internship project.

## 🌐 Live Demo

👉 [https://battle-game-simulation.onrender.com/battle](https://battle-game-simulation.onrender.com/battle)

> ⚠️ First load may take ~60 seconds if the server was idle (free hosting).

---

## 🎮 About the Game

You are **Kratos**, a legendary hero who has been fighting monsters for over a hundred years. As he walks through the forest, he encounters a wild monster — and the battle begins!

Each battle is randomly generated. Both Kratos and the monster start with random stats within their ranges:

|  | Kratos | Monster |
|---|---|---|
| ❤️ Health | 65 – 100 | 50 – 80 |
| ⚔️ Strength | 75 – 90 | 55 – 80 |
| 🛡️ Defence | 40 – 50 | 50 – 70 |
| 💨 Speed | 40 – 50 | 40 – 60 |
| 🍀 Luck | 10% – 20% | 30% – 45% |

Kratos also has 2 special skills:
- **Rapid Fire** — strikes twice in one turn (15% chance)
- **Magic Armour** — takes only half damage when defending (15% chance)

### How it works
- The fighter with higher **speed** attacks first (or higher **luck** if speed is equal)
- Each turn: `Damage = Attacker Strength – Defender Defence`
- The defender can **dodge** the hit based on their luck
- After each attack, roles switch
- The game ends when someone reaches **0 health** or after **15 turns**

---

## 🛠️ Built With

- **Backend:** PHP 8.2 / Laravel 8
- **Frontend:** Blade Templates, HTML, CSS
- **Server:** Docker, Nginx
- **Hosting:** Render.com

---

## 🚀 How It Was Deployed

The app is hosted for free on **Render.com**, connected to GitHub for automatic deploys.

- Every `git push` triggers a new deployment automatically
- The app runs inside a **Docker** container with Nginx
- The database is a free **PostgreSQL** instance on Render
- All secrets (passwords, app key) are stored in Render's environment variables — not in the code
- A deploy script runs `php artisan migrate --force` automatically on each deploy

---

## 💻 Run Locally

```bash
git clone https://github.com/Catinca2005/Battle-Game-Simulation.git
cd Battle-Game-Simulation
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Then open [http://localhost:8000/battle](http://localhost:8000/battle) in your browser.

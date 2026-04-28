<?php

use App\Http\Controllers\BattleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route to start a fresh battle
Route::get('/battle', [BattleController::class, 'start'])->name('battle.start');

// Route to view past battles
Route::get('/history', [BattleController::class, 'index'])->name('battle.index');

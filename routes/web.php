<?php

use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;
use App\Enums\Games\LinkEnum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainPageController::class, 'index'])->name('index');
Route::post('/', [MainPageController::class, 'register'])->name('register');

Route::middleware('check.link')->group(function () {
    Route::get('/lucky_number/{link}', [\App\Http\Controllers\Games\LuckyNumberController::class, 'gamePage'])
        ->name(LinkEnum::LuckyNumber->value . '.game_page');
    Route::post('/lucky_number/{link}/generate_new_link', [\App\Http\Controllers\Games\LuckyNumberController::class, 'generateNewLink'])
        ->name(LinkEnum::LuckyNumber->value . '.generate_new_link');
    Route::post('/lucky_number/{link}/deactivate_link', [\App\Http\Controllers\Games\LuckyNumberController::class, 'deactivateLink'])
        ->name(LinkEnum::LuckyNumber->value . '.deactivate_link');
    Route::post('/lucky_number/{link}/play', [\App\Http\Controllers\Games\LuckyNumberController::class, 'play'])
        ->name(LinkEnum::LuckyNumber->value . '.play');
    Route::post('/lucky_number/{link}/show_history', [\App\Http\Controllers\Games\LuckyNumberController::class, 'showHistory'])
        ->name(LinkEnum::LuckyNumber->value . '.show_history');
});

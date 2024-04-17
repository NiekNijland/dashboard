<?php

declare(strict_types=1);

use App\Http\Controllers\Ista;
use App\Http\Controllers\Profile;
use App\Http\Controllers\MotorOccasion;
use Illuminate\Support\Facades\Route;

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

Route::redirect('home', 'ista');

Route::prefix('ista')->group(static function (): void {
    Route::get('{period?}', Ista\IndexController::class)->name('ista');
});

Route::get('profile', Profile\IndexController::class)
    ->name('profile');

Route::get('motor-occasion', MotorOccasion\IndexController::class)
    ->name('motor-occasion');

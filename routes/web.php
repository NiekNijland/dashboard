<?php

declare(strict_types=1);

use App\Actions\MotorOccasion\Search;
use App\Enums\MotorOccasion\Brand;
use App\Enums\MotorOccasion\Model;
use App\Http\Controllers\Ista;
use App\Http\Controllers\Profile;
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

Route::get('test', static function (): void {
    $results = (new Search(Brand::SUZUKI, Model::GSXR_1100))->handle();

    foreach ($results->toArray() as $result) {
        dump($result);
    }
});

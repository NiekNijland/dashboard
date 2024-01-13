<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(static function (): void {
    Route::get('', static fn (): View => view('auth.login'))->name('login');
});

Route::middleware('auth')->group(static function (): void {
    Route::get('logout', static function (): RedirectResponse {
        Auth::logout();

        return redirect()->route('login');
    })->name('logout');
});

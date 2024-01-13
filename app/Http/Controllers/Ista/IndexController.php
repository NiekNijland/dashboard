<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ista;

use App\Actions\Ista\GetUsagePerMonth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class IndexController extends Controller
{
    public function __invoke(?string $period = null): View
    {
        $usages = match ($period) {
            'week' => Cache::get(
                'ista-week-usages',
                static fn (): DataCollection => (new GetUsagePerMonth())->handle()
            ),
            default => Cache::get(
                'ista-month-usages',
                static fn (): DataCollection => (new GetUsagePerMonth())->handle()
            ),
        };

        return view('ista.index', [
            'usages' => $usages,
        ]);
    }
}
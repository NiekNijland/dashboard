<?php

namespace App\Http\Controllers\Ista;

use App\Http\Controllers\Controller;
use App\Models\Ista\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $usages = Cache::get('ista-usages', static function (): Collection {
            return Usage::query()->get();
        });

        return view('ista.index', [
            'usages' => $usages,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\Ista;

use App\Data\Ista\Usage;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UsageWidget extends Component
{
    public function __construct(
        public readonly Usage $usage,
    ) {
    }

    public function render(): View
    {
        return view('components.dashboard.ista.usage-widget');
    }
}

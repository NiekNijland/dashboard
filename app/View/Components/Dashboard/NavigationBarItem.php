<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class NavigationBarItem extends Component
{
    public readonly bool $active;

    public function __construct(
        public string $route,
        public string $text,
    ) {
        $this->active = Request::url() === $route;
    }

    public function render(): View
    {
        return view('components.dashboard.navigation-bar-item');
    }
}

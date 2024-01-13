<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\Sidebar;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class SidebarLink extends SidebarElement
{
    public readonly bool $selected;

    public function __construct(
        public readonly string $routeName,
        public readonly string $text,
        public readonly string $icon,
    ) {
        $this->selected = $this->routeName === Route::currentRouteName();
    }

    public function render(): View
    {
        return view('components.dashboard.sidebar-element');
    }
}

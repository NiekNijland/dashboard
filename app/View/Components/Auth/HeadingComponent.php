<?php

declare(strict_types=1);

namespace App\View\Components\Auth;

use Illuminate\View\Component;
use Illuminate\View\View;

class HeadingComponent extends Component
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $alternativeRoute = null,
        public readonly ?string $alternativeTitle = null,
    ) {
    }

    public function render(): View
    {
        return view('components.auth.heading-component');
    }
}

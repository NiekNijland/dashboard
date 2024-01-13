<?php

declare(strict_types=1);

namespace App\View\Components\Dashboard\Sidebar;

use App\Http\Requests\AuthenticatedRequest;
use Illuminate\View\Component;
use Illuminate\View\View;

class Sidebar extends Component
{
    public readonly string $userName;

    public function __construct(AuthenticatedRequest $request)
    {
        $this->userName = $request->user->name;
    }

    public function render(): View
    {
        return view('components.dashboard.sidebar');
    }
}

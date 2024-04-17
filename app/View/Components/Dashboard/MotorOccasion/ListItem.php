<?php

namespace App\View\Components\Dashboard\MotorOccasion;

use App\Data\MotorOccasion\Result;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListItem extends Component
{
    public function __construct(public readonly Result $result)
    {
    }

    public function render(): View
    {
        return view('components.dashboard.motor-occasion.list-item');
    }
}

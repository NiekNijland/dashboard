<?php

declare(strict_types=1);

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Illuminate\View\View;

class ConfirmationModal extends Component
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $text,
        public string $buttonText = '',
        public readonly bool $success = true,
        public readonly ?string $buttonRoute = null,
    ) {
        if ($this->buttonText === '') {
            $this->buttonText = __('general.continue');
        }
    }

    public function render(): View
    {
        return view('components.modals.confirmation-modal');
    }
}

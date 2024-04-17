<?php

declare(strict_types=1);

namespace App\Livewire\Torrents;

use App\Actions\Torrents\ResetFilePermissions;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use RuntimeException;

class ResetPermissionsComponent extends Component
{
    public function resetPermissions(): void
    {
        try {
            (new ResetFilePermissions())->handle();

            $this->dispatch(event: 'file-permissions-reset');
        } catch (RuntimeException $exception) {
            $this->dispatch(event: 'file-permissions-reset-failed');
        }
    }

    public function render(): View
    {
        return view('livewire.torrents.reset-permissions-component');
    }
}

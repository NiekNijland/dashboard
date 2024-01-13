<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class LoginComponent extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public bool $error = false;

    /** @var array<string, array<int, string>> */
    public array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function render(): View
    {
        return view('livewire.auth.login-component');
    }

    public function updated(string $name): void
    {
        $this->validateOnly($name);
    }

    public function login(): void
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $this->redirect(RouteServiceProvider::HOME);
        }

        $this->error = true;
    }
}

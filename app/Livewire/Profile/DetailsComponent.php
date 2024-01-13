<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class DetailsComponent extends Component
{
    public string $firstName;

    public string $lastName;

    public string $email;

    /**
     * @return array<string, array<int, string|Enum>>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function render(): Renderable
    {
        return view('livewire.profile.details-component');
    }

    /**
     * @throws AuthenticationException
     */
    public function save(): void
    {
        $this->validate();

        get_auth_user()->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ]);

        $this->dispatch(event: 'show-profile-saved-confirmation-modal');
    }
}

<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

/**
 * @throws AuthenticationException
 */
function get_auth_user(): User
{
    $user = Auth::user();

    if ($user instanceof User) {
        return $user;
    }

    throw new AuthenticationException();
}

function try_get_auth_user(): ?User
{
    try {
        return get_auth_user();
    } catch (AuthenticationException) {
        return null;
    }
}

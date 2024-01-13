<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticatedRequest extends FormRequest
{
    public User $user;

    public function __construct()
    {
        parent::__construct();

        if (($user = try_get_auth_user()) instanceof User) {
            $this->user = $user;
        }
    }
}

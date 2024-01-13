<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(): View
    {
        return view('profile.index', [
            'user' => get_auth_user(),
        ]);
    }
}

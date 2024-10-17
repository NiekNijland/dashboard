<?php

declare(strict_types=1);

namespace App\Http\Controllers\MotorOccasion;

use App\Http\Controllers\Controller;
use App\Integrations\MotorOccasion\Http\Requests\IndexRequest;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request): View
    {
        return view('motor-occasion.index');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\MotorOccasion;

use App\Actions\MotorOccasion\Search;
use App\Enums\MotorOccasion\Brand;
use App\Enums\MotorOccasion\Model;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(): View
    {
        return view('motor_occasion.index', [
            'results' => (new Search(Brand::SUZUKI, Model::GSXR_1100))->handle(),
        ]);
    }
}

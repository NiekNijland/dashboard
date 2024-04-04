<?php

declare(strict_types=1);

namespace App\Actions\MotorOccasion;

use App\Actions\Action;
use App\Enums\MotorOccasion\Brand;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class SetBrand implements Action
{
    public function __construct(private string $sessionId, private Brand $brand)
    {
    }

    public function handle(): void
    {
        $response = Http::withCookies(['PHPSESSID' => $this->sessionId], 'www.motoroccasion.nl')
            ->get('https://www.motoroccasion.nl/mz.php?params%5Bbr%5D=' . $this->brand->value . '&' . 'params%5Ba%5D=check');

        if (! $response->ok()) {
            throw new RuntimeException('Could not set brand');
        }
    }
}

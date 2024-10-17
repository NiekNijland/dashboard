<?php

declare(strict_types=1);

namespace App\Integrations\MotorOccasion\Actions;

use App\Actions\Action;
use App\Data\MotorOccasion\Type;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class SetType implements Action
{
    public function __construct(private string $sessionId, private Type $type)
    {
    }

    public function handle(): void
    {
        $response = Http::withCookies(['PHPSESSID' => $this->sessionId], 'www.motoroccasion.nl')
            ->get('https://www.motoroccasion.nl/mz.php?params%5Bty%5D=' . $this->type->value . '&params%5Ba%5D=check');

        if (! $response->ok()) {
            throw new RuntimeException('Could not set model');
        }
    }
}

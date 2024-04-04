<?php

declare(strict_types=1);

namespace App\Actions\MotorOccasion;

use App\Actions\Action;
use App\Enums\MotorOccasion\Model;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class SetModel implements Action
{
    public function __construct(private string $sessionId, private Model $model)
    {
    }

    public function handle(): void
    {
        $response = Http::withCookies(['PHPSESSID' => $this->sessionId], 'www.motoroccasion.nl')
            ->get('https://www.motoroccasion.nl/mz.php?params%5Bty%5D=' . $this->model->value . '&params%5Ba%5D=check');

        if (! $response->ok()) {
            throw new RuntimeException('Could not set model');
        }
    }
}

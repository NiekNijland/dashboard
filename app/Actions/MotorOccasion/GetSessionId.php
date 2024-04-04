<?php

declare(strict_types=1);

namespace App\Actions\MotorOccasion;

use App\Actions\Action;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GetSessionId implements Action
{
    public function handle(): string
    {
        $response = Http::get('https://www.motoroccasion.nl');

        $sessionId = $response->cookies()->getCookieByName('PHPSESSID')?->getValue();

        if (! is_string($sessionId)) {
            throw new RuntimeException('Could not retrieve session ID');
        }

        return $sessionId;
    }
}

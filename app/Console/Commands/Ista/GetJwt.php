<?php

declare(strict_types=1);

namespace App\Console\Commands\Ista;

use App\Actions\Action;
use Illuminate\Support\Facades\Http;

readonly class GetJwt implements Action
{
    public function handle(): string
    {
        $response = Http::withHeaders([
            'authority' => 'mijn.ista.nl',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'content-type' => 'application/x-www-form-urlencoded',
        ])
            ->asForm()
            ->post('https://mijn.ista.nl/Identity/Account/Login?ReturnUrl=%2FHome', [
                'txtUserName' => config('ista.username'),
                'txtPassword' => config('ista.password'),
            ]);

        $debris = explode('id="__twj_" value="', $response->body());

        $debris = explode('"', $debris[1]);

        return $debris[0];
    }
}

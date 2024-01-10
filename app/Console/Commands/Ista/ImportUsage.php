<?php

declare(strict_types=1);

namespace App\Console\Commands\Ista;

use App\Actions\Ista\ImportUsage as ImportValuesAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ImportUsage extends Command
{
    /** @var string */
    protected $signature = 'ista:import-usage';

    /** @var string */
    protected $description = 'Import current usage from Ista';

    public function handle(): void
    {
        $jwtToken = (new GetJwt())->handle();

        (new ImportValuesAction($jwtToken))->handle();

        Cache::forget('ista-usages');
    }
}

<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\Ista\ImportUsage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ImportUsage::class)->dailyAt('23:00');

        $schedule->command('cache:prune-stale-tags')->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/../Integrations/MotorOccasion/Console/Commands');

        require base_path('routes/console.php');
    }
}

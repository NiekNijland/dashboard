<?php

declare(strict_types=1);

namespace App\Actions\Torrents;

use App\Actions\Action;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Process;
use RuntimeException;

class ResetFilePermissions implements Action
{
    /**
     * @throws RuntimeException
     */
    public function handle(): void
    {
        $chownResult = Process::run(
            implode(' ', [
                'sudo chown -R',
                Config::string('torrents.user') . ':' . Config::string('torrents.group'),
                Config::string('torrents.folder'),
            ])
        );

        $chmodResult = Process::run(
            implode(' ', [
                'sudo chmod -R',
                Config::string('torrents.permissions'),
                Config::string('torrents.folder'),
            ])
        );

        if ($chownResult->failed() || $chmodResult->failed()) {
            throw new RuntimeException('Failed to reset file permissions');
        }
    }
}

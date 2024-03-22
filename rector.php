<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__ . '/app',
            __DIR__ . '/database',
            __DIR__ . '/tests',
        ])
        ->withPhpSets()
        ->withImportNames()
        ->withPreparedSets(
            deadCode: true,
            typeDeclarations: true,
            privatization: true,
            instanceOf: true,
            strictBooleans: true,
        );
} catch (InvalidConfigurationException $e) {
}

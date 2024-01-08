<?php

declare(strict_types=1);

use Hashids\Hashids;

function route_key_to_id(string $routeKey): string
{
    return (string) (new Hashids)->decode($routeKey)[0];
}

function id_to_route_key(string $id): string
{
    return (new Hashids)->encode($id);
}

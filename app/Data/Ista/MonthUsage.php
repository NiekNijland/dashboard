<?php

declare(strict_types=1);

namespace App\Data\Ista;

class MonthUsage extends Usage
{
    public function title(): string
    {
        return $this->date->format('F Y');
    }
}

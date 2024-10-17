<?php

declare(strict_types=1);

namespace App\Integrations\MotorOccasion\Actions;

use App\Actions\Action;
use App\Data\MotorOccasion\Brand;
use App\Data\MotorOccasion\Result;
use App\Data\MotorOccasion\SearchQuery;
use App\Data\MotorOccasion\Type;
use Illuminate\Support\Collection;

readonly class Search implements Action
{
    public function __construct(private SearchQuery $searchQuery)
    {
    }

    /**
     * @return Collection<int, Result>
     */
    public function handle(): Collection
    {
        $sessionId = (new GetSessionId())->handle();

        (new SetBrand($sessionId, $this->searchQuery->brand))->handle();
        (new SetType($sessionId, $this->searchQuery->type))->handle();

        return (new GetResults($sessionId))->handle();
    }
}

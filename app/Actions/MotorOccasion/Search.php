<?php

declare(strict_types=1);

namespace App\Actions\MotorOccasion;

use App\Actions\Action;
use App\Data\MotorOccasion\Result;
use App\Enums\MotorOccasion\Brand;
use App\Enums\MotorOccasion\Model;
use Illuminate\Support\Collection;

readonly class Search implements Action
{
    public function __construct(private Brand $brand, private Model $model)
    {
    }

    /**
     * @return Collection<int, Result>
     */
    public function handle(): Collection
    {
        $sessionId = (new GetSessionId())->handle();

        (new SetBrand($sessionId, $this->brand))->handle();
        (new SetModel($sessionId, $this->model))->handle();

        return (new GetResults($sessionId))->handle();
    }
}

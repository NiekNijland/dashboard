<?php

namespace App\Livewire\Dashboard\MotorOccasion;

use App\Data\MotorOccasion\Result;
use App\Data\MotorOccasion\SearchQuery;
use App\Integrations\MotorOccasion\Actions\Search;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ResultsList extends Component
{
    /** @var array<int, Result> */
    public array $results;

    public function render(): Renderable
    {
        return view('livewire.dashboard.motor-occasion.results-list');
    }

    #[On('search')]
    public function loadResults(array $eventData): void
    {
        $searchQuery = SearchQuery::from($eventData['query']);

        $this->results = (new Search($searchQuery))->handle()->toArray();
    }
}

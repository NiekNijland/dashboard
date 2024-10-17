<?php

namespace App\Livewire\Dashboard\MotorOccasion;

use App\Data\MotorOccasion\SearchQuery;
use App\Models\MotorOccasion\Brand;
use App\Models\MotorOccasion\Type;
use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class SearchBar extends Component
{
    /** @var array<string, array<string, mixed>  */
    protected $queryString = [
        'selectedBrand' => ['except' => '', 'as' => 'b'],
        'selectedType' => ['except' => '', 'as' => 't']
    ];

    public string $selectedBrand = '';

    public string $selectedType = '';

    /** @var array<string, array<string, mixed>> $brands */
    public array $brands = [];

    /** @var array<string, array<string, mixed>> $types */
    public array $types = [];

    public function mount(): void
    {
        $this->brands = Brand::query()
            ->get()
            ->map(fn (Brand $brand): array => [
                'id' => $brand->id,
                'value' => $brand->value,
                'name' => $brand->name,
            ])
            ->toArray();

        if (!empty($this->selectedBrand)) {
            $this->updatedSelectedBrand();
            if (!empty($this->selectedType)) {
                $this->search();
            }
        }
    }

    public function render(): Renderable
    {
        return view('livewire.dashboard.motor-occasion.search-bar');
    }

    public function updatedSelectedBrand(): void
    {
        $this->types = Type::query()
            ->where('brand_id', $this->selectedBrand)
            ->get()
            ->map(fn (Type $type): array => [
                'id' => $type->id,
                'value' => $type->value,
                'name' => $type->name,
            ])
            ->toArray();
    }

    public function search(): void
    {
        if (empty($this->selectedBrand) || empty($this->selectedType)) {
            return;
        }

        /** @var Brand $brandModel */
        $brandModel = Brand::query()->findOrFail($this->selectedBrand);

        /** @var Type $typeModel */
        $typeModel = Type::query()->findOrFail($this->selectedType);

        $this->dispatch('search', [
            'query' => new SearchQuery(
                brand: \App\Data\MotorOccasion\Brand::fromModel($brandModel),
                type: \App\Data\MotorOccasion\Type::fromModel($typeModel),
            ),
        ]);
    }
}

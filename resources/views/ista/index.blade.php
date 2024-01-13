@extends('layouts.dashboard')

@section('navigation-bar')
    <x-dashboard.navigation-bar>
        <x-dashboard.navigation-bar-item route="{{ route('ista') }}" text="{{ __('general.month') }}" />
        <x-dashboard.navigation-bar-item route="{{ route('ista', ['period' => 'week']) }}" text="{{ __('general.week') }}" />
    </x-dashboard.navigation-bar>
@endsection

@section('content')
    @foreach ($usages as $usage)
        <div>
            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $usage->date->format('Y-m') }}</h3>
            <dl class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-2 md:divide-x md:divide-y-0">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-base font-normal text-gray-900">{{ __('ista.usage') }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                            {{ $usage->usage }}
                            <span class="ml-2 text-sm font-medium text-gray-500">{{ __('ista.units') }}</span>
                        </div>
                        <div
                            @class([
                                'inline-flex',
                                'items-baseline',
                                'rounded-full',
                                'px-2.5',
                                'py-0.5',
                                'text-sm',
                                'font-medium',
                                'md:mt-2',
                                'lg:mt-0',
                                'bg-red-100' => $usage->buildingDifferencePercentage < 0,
                                'text-red-800' => $usage->buildingDifferencePercentage < 0,
                                'bg-green-100' => $usage->buildingDifferencePercentage >= 0,
                                'text-green-800' => $usage->buildingDifferencePercentage >= 0,
                            ])
                        >
                            <span class="mr-1">
                            🏢
                            </span>
                            {{ $usage->buildingDifferencePercentage . '%' }}
                        </div>
                    </dd>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-base font-normal text-gray-900">{{ __('ista.usage_previous_year', ['year' => $usage->date->year - 1]) }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                            {{ $usage->usage_previous_year }}
                            <span class="ml-2 text-sm font-medium text-gray-500">{{ __('ista.units') }}</span>
                        </div>
                        <div
                            @class([
                                'inline-flex',
                                'items-baseline',
                                'rounded-full',
                                'px-2.5',
                                'py-0.5',
                                'text-sm',
                                'font-medium',
                                'md:mt-2',
                                'lg:mt-0',
                                'bg-red-100' => $usage->previousYearDifferencePercentage > 0,
                                'text-red-800' => $usage->previousYearDifferencePercentage > 0,
                                'bg-green-100' => $usage->previousYearDifferencePercentage <= 0,
                                'text-green-800' => $usage->previousYearDifferencePercentage <= 0,
                            ])
                        >
                            {{ $usage->previousYearDifferencePercentage . '%' }}
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    @endforeach
@endsection

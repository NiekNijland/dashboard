@extends('layouts.dashboard')

@section('navigation-bar')
    <x-dashboard.navigation-bar>
        <x-dashboard.navigation-bar-item route="{{ route('ista') }}" text="{{ __('general.month') }}" />
        <x-dashboard.navigation-bar-item route="{{ route('ista', ['period' => 'week']) }}" text="{{ __('general.week') }}" />
    </x-dashboard.navigation-bar>
@endsection

@section('content')
    @foreach ($usages as $usage)
        <x-dashboard.ista.usage-widget :usage="$usage" />
    @endforeach
@endsection

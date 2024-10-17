@extends('layouts.dashboard')

@section('navigation-bar')
    <livewire:dashboard.motor-occasion.search-bar />
@endsection

@section('content')
    <livewire:dashboard.motor-occasion.results-list />
@endsection


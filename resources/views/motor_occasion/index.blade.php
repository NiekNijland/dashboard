@extends('layouts.dashboard')

@section('content')
    @foreach($results as $result)
        <x-dashboard.motor-occasion.list-item :result="$result" />
    @endforeach
@endsection


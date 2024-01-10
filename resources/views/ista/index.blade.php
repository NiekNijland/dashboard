@extends('app')

@section('content')
    <ul>
    @foreach ($usages as $usage)
        <li>{{ $usage->date->format('d-m-Y') }}: {{ $usage->usage }}</li>
    @endforeach
    </ul>
@endsection

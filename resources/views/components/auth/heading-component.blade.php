<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <img class="mx-auto h-24 w-auto" src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}">
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
        {{ $title }}
    </h2>
    @if (!is_null($alternativeRoute) && !is_null($alternativeTitle))
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('general.or') }}
            <a href="{{ $alternativeRoute }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                {{ $alternativeTitle }}
            </a>
        </p>
    @endif
</div>

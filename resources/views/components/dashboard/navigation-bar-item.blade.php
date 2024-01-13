<a
    href="{{ $route }}"
    @class([
        'inline-flex',
        'items-center',
        'border-b-2',
        'border-indigo-500' => $active,
        'border-transparent' => !$active,
        'px-1',
        'pt-1',
        'text-sm',
        'font-medium',
        'text-gray-900' => $active,
        'text-gray-500' => !$active,
        'hover:border-gray-300' => !$active,
        'hover:text-gray-700' => !$active,
    ])
>
    {{ $text }}
</a>

<a
    href="{{ route($routeName) }}"
    @class([
        'bg-gray-900' => $selected,
        'text-white' => $selected,
        'text-gray-300' => !$selected,
        'hover:bg-gray-700' => !$selected,
        'hover:text-white' => !$selected,
        'group',
        'flex',
        'items-center',
        'px-2',
        'py-2',
        'text-sm',
        'font-medium',
        'rounded-md',
    ])
>
    <svg
        @class([
            'text-gray-300' => $selected,
            'text-gray-400 ' => !$selected,
            'group-hover:text-gray-300' => !$selected,
            'mr-4',
            'flex-shrink-0',
            'h-6',
            'w-6',
        ])
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        aria-hidden="true"
    >
        {!! $icon !!}
    </svg>
    <span class="ml-3">
        {{ $text }}
    </span>
</a>

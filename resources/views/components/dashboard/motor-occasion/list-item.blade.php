<a href="{{ 'https://motoroccasion.nl/' . $result->url }}">
    <div class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border mb-4 hover:shadow-md hover:cursor-pointer">
        <div class="flex items-center sm:items-start">
            <div class="h-20 w-32 flex-shrink-0 overflow-hidden rounded-l-lg bg-gray-200 sm:h-40 sm:w-60">
                <img src="{{ $result->image }}" alt="image" class="h-full w-full object-cover object-center">
            </div>
            <div class="ml-6 flex-1 text-sm py-6 ps-4 pe-8">
                <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                    <h5>{{ $result->brand . ' ' . $result->model }}</h5>
                    <p class="mt-2 sm:mt-0">{{ '€' . number_format($result->price, 0, ',', '.') }}</p>
                </div>
                <p class="hidden text-gray-500 sm:mt-2 sm:block">Are you a minimalist looking for a compact carry option? The Micro Backpack is the perfect size for your essential everyday carry items. Wear it like a backpack or carry it like a satchel for all-day use.</p>
            </div>
        </div>
    </div>
</a>

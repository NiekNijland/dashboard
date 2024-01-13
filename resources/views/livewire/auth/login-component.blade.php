<div>
    <x-auth.heading-component
        title="{{ __('auth.sign_into', ['name' => config('app.name')]) }}"
    />
    @if($error)
        <div class="text-center">
            <p class="mt-8 text-lg leading-6 text-red-600">{{ __('auth.failed') }}</p>
        </div>
    @endif
    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 mt-{{ $error ? '8' : '12' }}">
        <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('general.email') }}</label>
            <div class="mt-1">
                <input
                    wire:model.defer="email"
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    @class([
                        'block',
                        'w-full',
                        'rounded-md',
                        'border-gray-300',
                        'py-3',
                        'px-4',
                        'shadow-sm',
                        'focus:border-indigo-500',
                        'focus:ring-indigo-500',
                        'border-red-600' => $this->getErrorBag()->has('email'),
                        'ring-red-600' => $this->getErrorBag()->has('email'),
                    ])
                >
                @error('email')
                <div class="text-sm text-red-600 ml-1 mt-1">
                    <label for="email" class="font-medium">
                        {{ $message }}
                    </label>
                </div>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('general.password') }}
            </label>
            <div class="mt-1">
                <input
                    wire:model="password"
                    type="password"
                    name="password"
                    id="password"
                    autocomplete="off"
                    @class([
                        'block',
                        'w-full',
                        'rounded-md',
                        'border-gray-300',
                        'py-3',
                        'px-4',
                        'shadow-sm',
                        'focus:border-indigo-500',
                        'focus:ring-indigo-500',
                        'border-red-600' => $this->getErrorBag()->has('password'),
                        'ring-red-600' => $this->getErrorBag()->has('password'),
                    ])
                >
                @error('password')
                <div class="text-sm text-red-600 ml-1 mt-1">
                    <label for="password" class="font-medium">
                        {{ $message }}
                    </label>
                </div>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-2">
            <div class="flex items-center justify-between">
                <div class="flex h-5 items-center">
                    <input
                        id="remember"
                        wire:model="remember"
                        aria-describedby="comments-description"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        wire:model="user.first_name"
                    >
                    <div class="ml-3 text-sm">
                        <label for="remember" class="font-medium text-gray-700">{{ __('auth.remember') }}</label>
                    </div>
                </div>
                <div class="text-sm">
                    <a href="#" onclick="alert('loser')" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('auth.forgot_password') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="sm:col-span-2">
            <button wire:click="login" type="submit" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __('auth.sign_in') }}
            </button>
        </div>
    </div>
</div>

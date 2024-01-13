@extends('layouts.auth')

@section('content')
    <livewire:auth.register-component />
    <x-modals.confirmation-modal
        id="sign-up-confirmation-modal"
        title="{{ __('auth.sign_up_success') }}"
        text="{{ __('auth.you_can_now_login') }}"
        button-route="{{ route('login') }}"
    />
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(() => {
            $(document).on('show-sign-up-confirmation-modal', () => {
                $('#sign-up-confirmation-modal').removeClass('hidden');
            });
        });
    </script>
@endpush

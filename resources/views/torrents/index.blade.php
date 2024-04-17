@extends('layouts.dashboard')

@section('content')
    <livewire:torrents.reset-permissions-component />
    <x-modals.confirmation-modal
        id="permissions-reset-confirmation-modal"
        title="{{ __('torrents.permissions.reset_confirmation.title') }}"
        text="{{ __('torrents.permissions.reset_confirmation.text') }}"
        button-route="{{ route('torrents') }}"
    />
    <x-modals.confirmation-modal
        id="permissions-reset-failed-confirmation-modal"
        title="{{ __('torrents.permissions.reset_failed_confirmation.title') }}"
        text="{{ __('torrents.permissions.reset_failed_confirmation.text') }}"
        button-route="{{ route('torrents') }}"
        success="0"
    />
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(() => {
            $(document).on('file-permissions-reset', () => {
                $('#permissions-reset-confirmation-modal').removeClass('hidden');
            });

            $(document).on('file-permissions-reset-failed', () => {
                $('#permissions-reset-failed-confirmation-modal').removeClass('hidden');
            });
        });
    </script>
@endpush

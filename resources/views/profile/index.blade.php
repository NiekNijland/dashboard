@extends('layouts.dashboard')

@section('content')
    <livewire:profile.details-component
        :first-name="$user->first_name"
        :last-name="$user->last_name"
        :email="$user->email"
    />
    <x-modals.confirmation-modal
        id="profile-saved-confirmation-modal"
        title="{{ __('profile.saved') }}"
        text="{{ __('profile.changes_saved') }}"
        button-route="{{ route('profile') }}"
    />
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(() => {
            $(document).on('show-profile-saved-confirmation-modal', () => {
                $('#profile-saved-confirmation-modal').removeClass('hidden');
            });
        });
    </script>
@endpush

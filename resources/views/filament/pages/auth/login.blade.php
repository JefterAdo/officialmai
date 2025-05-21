@php
    $hasLogo = filled($logo = config('filament.layout.logo'));
@endphp

<x-filament-panels::page.simple>
    <x-slot name="title">
        {{ __('filament-panels::pages/auth/login.title') }}
    </x-slot>

    <div class="flex items-center justify-center">
        @if ($hasLogo)
            <div class="mb-4">
                <img src="{{ $logo }}" alt="{{ config('app.name') }}" class="h-12">
            </div>
        @endif
    </div>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :full-width="true"
            :actions="$this->getCachedFormActions()"
            :alignment="'start'"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple> 
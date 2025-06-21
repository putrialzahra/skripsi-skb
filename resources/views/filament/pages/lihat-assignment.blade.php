<x-filament-panels::page>
    {{ $this->form }}

    <x-filament::button wire:click="saveScores" class="mt-4">
        Simpan Nilai
    </x-filament::button>
</x-filament-panels::page>
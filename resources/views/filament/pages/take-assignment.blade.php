<div>
    <x-filament::card>
        {{ $this->form }}
    </x-filament::card>

    <x-filament::button wire:click="submit" class="mt-4">
        Simpan
    </x-filament::button>
</div>
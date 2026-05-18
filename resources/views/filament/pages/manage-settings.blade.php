<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        
        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit" size="md">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
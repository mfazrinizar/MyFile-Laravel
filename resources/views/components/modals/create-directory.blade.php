<!-- Create Directory Modal -->

@props(['showCreateDirectoryModal', 'newDirectoryName'])
<flux:modal wire:model="showCreateDirectoryModal">
    <form wire:submit.prevent="createDirectory">
        <h2 class="text-xl font-bold">{{ __('Create Directory') }}</h2>
        <input type="text" wire:model="newDirectoryName" placeholder="{{ __('Directory Name') }}" class="mt-4">
        <div class="mt-6 flex justify-end gap-4">
            <flux:button variant="filled" wire:click="$set('showCreateDirectoryModal', false)">
                {{ __('Cancel') }}</flux:button>
            <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
        </div>
    </form>
</flux:modal>

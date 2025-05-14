<!-- Delete Confirmation Modal -->

@props(['deleteDirectoryId', 'deleteFileId', 'showDeleteModal'])

<flux:modal wire:model="showDeleteModal" focusable>
    <form wire:submit.prevent="delete">
        <div class="p-6">
            <h2 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('Confirm Deletion') }}</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                @if ($deleteDirectoryId)
                    {{ __('Are you sure you want to delete this directory? This will also delete all files and subdirectories inside. This action cannot be undone.') }}
                @else
                    {{ __('Are you sure you want to delete this file? This action cannot be undone.') }}
                @endif
            </p>
        </div>
        <div class="flex justify-end space-x-2 p-6">
            <flux:button variant="filled" wire:click="$set('showDeleteModal', false)">
                {{ __('Cancel') }}
            </flux:button>
            <flux:button variant="danger" type="submit">
                {{ __('Delete') }}
            </flux:button>
        </div>
    </form>
</flux:modal>

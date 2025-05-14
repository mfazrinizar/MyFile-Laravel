<!-- Share Link Modal -->
@props(['showShareLinkModal', 'shareLink'])

<flux:modal wire:model="showShareLinkModal" focusable>
    <div class="p-6" x-data="{ show: false }">
        <h2 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('Share Link') }}</h2>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Copy the link below to share this item:') }}
        </p>
        <div class="mt-4 flex gap-2">
            <input x-ref="input" type="text" readonly value="{{ $shareLink }}"
                class="w-full rounded border border-zinc-300 p-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
            <flux:button type="button" variant="outline"
                x-on:click="
                    navigator.clipboard.writeText($refs.input.value);
                    show = true;
                    setTimeout(() => show = false, 1500);
                ">
                {{ __('Copy') }}
            </flux:button>
        </div>
        <span x-show="show" class="text-green-600 text-xs">{{ __('Copied!') }}</span>
    </div>
    <div class="flex justify-end space-x-2 p-6">
        <flux:button variant="filled" wire:click="$set('showShareLinkModal', false)">
            {{ __('Close') }}
        </flux:button>
    </div>
</flux:modal>

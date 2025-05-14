{{-- filepath: resources/views/livewire/partials/directory-tree.blade.php --}}
<li x-data="{ open: false }" class="flex flex-col">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <!-- Toggle Button for Subdirectories -->
            <button @click="open = !open">
                <i x-show="open" class="fas fa-chevron-down text-zinc-600 dark:text-zinc-400">X</i>
                <i x-show="!open" class="fas fa-chevron-right text-zinc-600 dark:text-zinc-400">O</i>
            </button>
            <!-- Directory Icon -->
            <x-icon name="folder" class="w-5 h-5 text-yellow-500" />
            <!-- Directory Name (Truncated) -->
            <span class="font-bold text-zinc-800 dark:text-white truncate w-48" title="{{ $directory->name }}">
                {{ $directory->name }}
            </span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $directory->created_at->format('Y-m-d H:i') }}
            </span>
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">
                    {{ __('Options') }}
                </flux:button>
                <flux:menu>
                    <flux:menu.item wire:click="openUploadModal('{{ $directory->id }}')" icon="plus">
                        {{ __('Upload File') }}
                    </flux:menu.item>
                    <flux:menu.item wire:click="openCreateDirectoryModal('{{ $directory->id }}')" icon="folder-plus">
                        {{ __('Create Subdirectory') }}
                    </flux:menu.item>
                    <flux:menu.separator />
                    <flux:menu.item wire:click="toggleDirectoryPrivacy('{{ $directory->id }}')" icon="lock-closed">
                        {{ $directory->share ? __('Make Private') : __('Make Public') }}
                    </flux:menu.item>
                    <flux:menu.item wire:click="generateDirectoryShareLink('{{ $directory->id }}')" icon="link">
                        {{ __('Share Link') }}
                    </flux:menu.item>
                    <flux:menu.item variant="danger" wire:click="openDeleteDirectoryModal('{{ $directory->id }}')"
                        icon="trash">
                        {{ __('Delete') }}
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>
    </div>

    <!-- Subdirectories and Files -->
    <ul x-show="open" class="ml-6 mt-2 space-y-2">
        @foreach ($directory->files as $file)
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <x-icon name="document" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                    <span class="text-zinc-600 dark:text-zinc-400 truncate w-48" title="{{ $file->name }}">
                        {{ $file->name }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ number_format($file->size / 1024, 2) }} KB
                    </span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $file->created_at->format('Y-m-d H:i') }}
                    </span>
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down">
                            {{ __('Options') }}
                        </flux:button>
                        <flux:menu>
                            <flux:menu.item wire:click="downloadFile('{{ $file->id }}')" target="_blank"
                                icon="document-arrow-down">
                                {{ __('Download') }}
                            </flux:menu.item>
                            <!-- Toggle privacy via file->share existence -->
                            <flux:menu.item wire:click="toggleFilePrivacy('{{ $file->id }}')" icon="lock-closed">
                                {{ $file->share ? __('Make Private') : __('Make Public') }}
                            </flux:menu.item>

                            <flux:menu.item wire:click="generateFileShareLink('{{ $file->id }}')" icon="link">
                                {{ __('Share Link') }}
                            </flux:menu.item>

                            <flux:menu.item variant="danger" wire:click="openDeleteFileModal('{{ $file->id }}')"
                                icon="trash">
                                {{ __('Delete') }}
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </li>
        @endforeach

        @foreach ($directory->children as $childDirectory)
            @include('livewire.partials.directory-tree', ['directory' => $childDirectory])
        @endforeach
    </ul>
</li>

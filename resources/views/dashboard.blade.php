<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- File Management Section -->
        <section class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">{{ __('Your Storage') }}</h2>
            <div class="flex justify-between items-center mt-4">
                <!-- Upload File Button -->
                <flux:button variant="primary" wire:click="openUploadModal">{{ __('Upload File') }}</flux:button>
                <!-- Create Directory Button -->
                <flux:button variant="filled" wire:click="openCreateDirectoryModal">{{ __('Create Directory') }}
                </flux:button>
            </div>

            <!-- Root-Level Files -->
            <div class="mt-6">
                <h3 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('Root Files') }}</h3>
                <ul class="space-y-2">
                    @foreach ($rootFiles as $file)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <!-- File Icon -->
                                <x-icon name="document" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                                <!-- File Name (Truncated) -->
                                <span class="text-zinc-600 dark:text-zinc-400 truncate w-48"
                                    title="{{ $file->name }}">
                                    {{ $file->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4">
                                <!-- File Info -->
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ number_format($file->size / 1024, 2) }} KB
                                </span>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $file->created_at->format('Y-m-d H:i') }}
                                </span>
                                <!-- Flux dropdown for file actions -->
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
                                        <flux:menu.item wire:click="toggleFilePrivacy('{{ $file->id }}')"
                                            icon="lock-closed">
                                            {{ $file->share ? __('Make Private') : __('Make Public') }}
                                        </flux:menu.item>

                                        <flux:menu.item wire:click="generateFileShareLink('{{ $file->id }}')"
                                            icon="link">
                                            {{ __('Share Link') }}
                                        </flux:menu.item>

                                        <flux:menu.item variant="danger"
                                            wire:click="openDeleteFileModal('{{ $file->id }}')" icon="trash">
                                            {{ __('Delete') }}
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Root-Level Directories -->
            <div class="mt-6">
                <h3 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('Directory Tree') }}</h3>
                <ul class="tree">
                    @foreach ($directories as $directory)
                        {{-- filepath: resources/views/livewire/partials/directory-tree.blade.php --}}
                        <li x-data="{ open: false }" class="flex flex-col">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <!-- Toggle Button for Subdirectories -->
                                    <button @click="open = !open">
                                        <i x-show="open"
                                            class="fas fa-chevron-down text-zinc-600 dark:text-zinc-400">X</i>
                                        <i x-show="!open"
                                            class="fas fa-chevron-right text-zinc-600 dark:text-zinc-400">O</i>
                                    </button>
                                    <!-- Directory Icon -->
                                    <x-icon name="folder" class="w-5 h-5 text-yellow-500" />
                                    <!-- Directory Name (Truncated) -->
                                    <span class="font-bold text-zinc-800 dark:text-white truncate w-48"
                                        title="{{ $directory->name }}">
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
                                            <flux:menu.item wire:click="openUploadModal('{{ $directory->id }}')"
                                                icon="plus">
                                                {{ __('Upload File') }}
                                            </flux:menu.item>
                                            <flux:menu.item
                                                wire:click="openCreateDirectoryModal('{{ $directory->id }}')"
                                                icon="folder-plus">
                                                {{ __('Create Subdirectory') }}
                                            </flux:menu.item>
                                            <flux:menu.separator />
                                            <flux:menu.item wire:click="toggleDirectoryPrivacy('{{ $directory->id }}')"
                                                icon="lock-closed">
                                                {{ $directory->share ? __('Make Private') : __('Make Public') }}
                                            </flux:menu.item>
                                            <flux:menu.item
                                                wire:click="generateDirectoryShareLink('{{ $directory->id }}')"
                                                icon="link">
                                                {{ __('Share Link') }}
                                            </flux:menu.item>
                                            <flux:menu.item variant="danger"
                                                wire:click="openDeleteDirectoryModal('{{ $directory->id }}')"
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
                                            <span class="text-zinc-600 dark:text-zinc-400 truncate w-48"
                                                title="{{ $file->name }}">
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
                                                    <flux:menu.item wire:click="downloadFile('{{ $file->id }}')"
                                                        target="_blank" icon="document-arrow-down">
                                                        {{ __('Download') }}
                                                    </flux:menu.item>
                                                    <flux:menu.item
                                                        wire:click="toggleFilePrivacy('{{ $file->id }}')"
                                                        icon="lock-closed">
                                                        {{ $file->share ? __('Make Private') : __('Make Public') }}
                                                    </flux:menu.item>
                                                    <flux:menu.item
                                                        wire:click="generateFileShareLink('{{ $file->id }}')"
                                                        icon="link">
                                                        {{ __('Share Link') }}
                                                    </flux:menu.item>
                                                    <flux:menu.item variant="danger"
                                                        wire:click="openDeleteFileModal('{{ $file->id }}')"
                                                        icon="trash">
                                                        {{ __('Delete') }}
                                                    </flux:menu.item>
                                                </flux:menu>
                                            </flux:dropdown>
                                        </div>
                                    </li>
                                @endforeach

                                @foreach ($directory->children as $childDirectory)
                                    @include('livewire.partials.directory-tree', [
                                        'directory' => $childDirectory,
                                    ])
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <x-modals.share-link :showShareLinkModal="$showShareLinkModal" :shareLink="$shareLink" />
        <x-modals.delete-confirmation :deleteDirectoryId="$deleteDirectoryId" :deleteFileId="$deleteFileId" :showDeleteModal="$showDeleteModal" />
        <x-modals.upload-file :showUploadModal="$showUploadModal" :uploadedFile="$uploadedFile" />
        <x-modals.create-directory :showCreateDirectoryModal="$showCreateDirectoryModal" :newDirectoryName="$newDirectoryName" />

    </div>
</div>

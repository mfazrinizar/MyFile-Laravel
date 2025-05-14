<!-- filepath: d:\Projects\PHP\myfile-fix\resources\views\livewire\partials\directory.blade.php -->
<li>
    <div class="flex items-center justify-between">
        <span class="font-bold text-zinc-800 dark:text-white">{{ $directory->name }}</span>

        <!-- Flux dropdown for directory actions -->
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
                <flux:menu.separator />
                <flux:menu.item wire:click="deleteDirectory('{{ $directory->id }}')" variant="danger" icon="trash">
                    {{ __('Delete') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>

    <!-- Files in the directory -->
    <ul class="ml-6 mt-2">
        @foreach ($directory->files as $file)
            <li class="flex items-center justify-between">
                <span class="text-zinc-600 dark:text-zinc-400">{{ $file->name }}</span>

                <!-- Flux dropdown for file actions -->
                <flux:dropdown>
                    <flux:button icon:trailing="chevron-down">
                        {{ __('Options') }}
                    </flux:button>

                    <flux:menu>
                        <flux:menu.item wire:click="toggleFilePrivacy('{{ $file->id }}')" icon="lock-closed">
                            {{ $file->share ? __('Make Private') : __('Make Public') }}
                        </flux:menu.item>
                        <flux:menu.item wire:click="generateFileShareLink('{{ $file->id }}')" icon="link">
                            {{ __('Share Link') }}
                        </flux:menu.item>
                        <flux:menu.separator />
                        <flux:menu.item wire:click="deleteFile('{{ $file->id }}')" variant="danger" icon="trash">
                            {{ __('Delete') }}
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </li>
        @endforeach
    </ul>

    <!-- Subdirectories -->
    @if ($directory->children->isNotEmpty())
        <ul class="ml-6 mt-2">
            @foreach ($directory->children as $childDirectory)
                @include('livewire.partials.directory', ['directory' => $childDirectory])
            @endforeach
        </ul>
    @endif
</li>
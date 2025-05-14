<!-- filepath: d:\Projects\PHP\myfile-fix\resources\views\share\show.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- Header -->
    <flux:header container class="pt-4 pb-4 border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <a href="{{ route('dashboard') }}"
            class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0 animate-fade-in-down" wire:navigate>
            <x-app-logo />
        </a>
        <flux:spacer />
    </flux:header>

    <!-- Content -->
    <div class="container mx-auto mt-10">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">{{ __('Shared Resource') }}</h1>

            @if ($isFile)
                <div class="mt-4">
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('File Details') }}</h2>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('Name:') }} {{ $resource->name ?? 'Unnamed File' }}</p>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('Size:') }} {{ number_format($resource->size / 1024, 2) }} KB</p>
                    <a href="{{ route('download.file', $resource->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                        {{ __('Download') }}
                    </a>
                </div>
            @else
                <div class="mt-4">
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">{{ __('Directory Details') }}</h2>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('Name:') }} {{ $resource->name ?? 'Unnamed Directory' }}</p>
                    <ul class="mt-4 space-y-2">
                        @foreach ($resource->files as $file)
                            <li class="flex justify-between items-center">
                                <span class="text-zinc-600 dark:text-zinc-400">{{ $file->name ?? 'Unnamed File' }}</span>
                                <a href="{{ route('download.file', $file->id) }}" class="text-blue-500">{{ __('Download') }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    @livewireScripts
</body>

</html>
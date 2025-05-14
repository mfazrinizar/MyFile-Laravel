<!-- filepath: d:\Projects\PHP\myfile-fix\resources\views\welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- Header -->
    <flux:header container class="pt-4 pb-4 border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('dashboard') }}"
            class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0 animate-fade-in-down" wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        <nav class="flex items-center gap-6 animate-fade-in-up">
            @if (Route::has('login'))
                @auth
                    <flux:navbar class="-mb-px max-lg:hidden">
                        <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navbar.item>
                    </flux:navbar>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-zinc-800 dark:text-white hover:underline">{{ __('Log in') }}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-sm font-medium text-zinc-800 dark:text-white hover:underline">{{ __('Register') }}</a>
                    @endif
                @endauth
            @endif
        </nav>
    </flux:header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-sky-500 to-purple-600 text-white py-20 overflow-hidden">
        <div class="container mx-auto px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-extrabold mb-6 animate-fade-in-down">{{ __('Welcome to MyFile') }}</h1>
            <p class="text-lg mb-8 animate-fade-in-up">
                {{ __('Your open-source cloud file storage system for secure, modern file management.') }}</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-white text-sky-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-transform transform hover:scale-105 animate-bounce-in">
                    {{ __('Get Started') }}
                </a>
                <a href="{{ route('login') }}"
                    class="px-8 py-4 bg-transparent border border-white text-white font-bold rounded-lg hover:bg-white hover:text-sky-600 transition-transform transform hover:scale-105 animate-bounce-in">
                    {{ __('Log In') }}
                </a>
            </div>
        </div>
        <div class="absolute inset-0 -z-10">
            <div
                class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 opacity-30 w-full h-full animate-gradient-x">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-zinc-50 dark:bg-zinc-900">
        <div class="container mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-zinc-800 dark:text-white mb-12 animate-fade-in-down">
                {{ __('Features') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <flux:icon.folder-plus name="upload" class="h-12 w-12 text-green-500 mb-4" />
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white">{{ __('Upload & Organize') }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        {{ __('Easily upload and organize your files into directories for better management.') }}</p>
                </div>
                <div
                    class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <flux:icon.share name="share" class="h-12 w-12 text-blue-500 mb-4" />
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white">{{ __('Secure Sharing') }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        {{ __('Share files and directories securely with public or private links.') }}</p>
                </div>
                <div
                    class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <flux:icon.lock-closed name="lock" class="h-12 w-12 text-red-500 mb-4" />
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white">{{ __('Privacy & Security') }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        {{ __('Enjoy robust security and privacy for your data with advanced encryption.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white dark:bg-zinc-800">
        <div class="container mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-zinc-800 dark:text-white mb-12 animate-fade-in-down">
                {{ __('What Our Users Say') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="p-6 bg-zinc-50 dark:bg-zinc-900 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <p class="text-zinc-600 dark:text-zinc-400 italic">
                        "{{ __('MyFile has completely transformed the way I manage my files. It’s fast, secure, and easy to use!') }}"
                    </p>
                    <h4 class="mt-4 font-bold text-zinc-800 dark:text-white">- {{ __('John Doe') }}</h4>
                </div>
                <div
                    class="p-6 bg-zinc-50 dark:bg-zinc-900 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <p class="text-zinc-600 dark:text-zinc-400 italic">
                        "{{ __('The sharing features are amazing. I can securely share files with my team in seconds.') }}"
                    </p>
                    <h4 class="mt-4 font-bold text-zinc-800 dark:text-white">- {{ __('Jane Smith') }}</h4>
                </div>
                <div
                    class="p-6 bg-zinc-50 dark:bg-zinc-900 rounded-lg shadow transform transition-transform hover:scale-105 animate-fade-in-up">
                    <p class="text-zinc-600 dark:text-zinc-400 italic">
                        "{{ __('I love the open-source nature of MyFile. It’s great to see such a powerful tool available for free.') }}"
                    </p>
                    <h4 class="mt-4 font-bold text-zinc-800 dark:text-white">- {{ __('Alex Johnson') }}</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-zinc-50 dark:bg-zinc-900">
        <div class="container mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">&copy; {{ date('Y') }} MyFile.
                {{ __('All rights reserved.') }}</p>
            <p class="mt-4">
                <a href="https://github.com/mfazrinizar/MyFile-Laravel" target="_blank"
                    class="hover:underline text-zinc-800 dark:text-white">{{ __('GitHub') }}</a> |
                <a href="https://github.com/mfazrinizar/MyFile-Laravel/blob/main/README.md" target="_blank"
                    class="hover:underline text-zinc-800 dark:text-white">{{ __('Documentation') }}</a>
            </p>
        </div>
    </footer>

    @livewireScripts
</body>

</html>

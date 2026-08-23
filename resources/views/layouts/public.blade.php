<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <header class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-medium" wire:navigate>
            <x-app-logo-icon class="size-8 fill-current text-black dark:text-white" />
            <span>{{ config('app.name', 'Laravel') }}</span>
        </a>

        <nav class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
            @else
                <a href="{{ route('login') }}" wire:navigate>Log in</a>
            @endauth
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} — Praktikum Basis Data</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#09090b] text-gray-100 selection:bg-[#D4A853]/30">
        <div class="min-h-screen flex flex-col relative overflow-hidden">
            
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#D4A853]/10 rounded-full blur-3xl pointer-events-none"></div>

            @include('layouts.navigation')

            @isset($header)
                <header class="bg-[#111113]/80 backdrop-blur-md border-b border-gray-800 shadow-sm relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        {{ $header }}
                        
                        <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            System Online
                        </div>
                    </div>
                </header>
            @endisset

            <main class="relative z-10 flex-1">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
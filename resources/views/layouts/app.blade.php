<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Encryption Tools</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-900">Encryption Tools</a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('text-encryption') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('text-encryption*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">Text Encryption</a>
                    <a href="{{ route('file-encryption') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('file-encryption*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">File Encryption</a>
                    <a href="{{ route('hash-tools') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('hash-tools*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">Hash Tools</a>
                    <a href="{{ route('password-tools') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('password-tools*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">Password Tools</a>
                    <a href="{{ route('secure-notes') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('secure-notes*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">Secure Notes</a>
                    <a href="{{ route('qr-code') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('qr-code*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">QR Code</a>
                    <a
                        href="{{ route('secure-credentials') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('secure-credentials*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">
                        Credential Vault
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</body>

</html>
@extends('layouts.app')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Encryption Tools Dashboard</h1>
        <p class="text-gray-600">Select a tool below to get started</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('text-encryption') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-blue-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Text Encryption</h3>
            <p class="text-gray-500 text-sm mt-1">AES-256, Base64, Caesar, Vigenere, URL-safe encoding</p>
        </a>

        <a href="{{ route('file-encryption') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-green-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">File Encryption</h3>
            <p class="text-gray-500 text-sm mt-1">Encrypt and decrypt files with AES-256</p>
        </a>

        <a href="{{ route('hash-tools') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-purple-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Hash Tools</h3>
            <p class="text-gray-500 text-sm mt-1">MD5, SHA-256, SHA-512, bcrypt, Argon2, HMAC</p>
        </a>

        <a href="{{ route('password-tools') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-orange-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h6zm-6 4v2m6-2v2m-9 4h.01M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Password Tools</h3>
            <p class="text-gray-500 text-sm mt-1">Generate, check strength, hash and verify passwords</p>
        </a>

        <a href="{{ route('secure-notes') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-red-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Secure Notes</h3>
            <p class="text-gray-500 text-sm mt-1">Create encrypted notes with password protection</p>
        </a>

        <a href="{{ route('qr-code') }}" class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 border border-gray-200">
            <div class="text-indigo-600 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">QR Code</h3>
            <p class="text-gray-500 text-sm mt-1">Generate QR codes from text or encrypted messages</p>
        </a>
    </div>
@endsection

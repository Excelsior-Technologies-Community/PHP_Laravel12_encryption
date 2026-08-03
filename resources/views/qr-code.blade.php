@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">QR Code Generator</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif
    @if($qr ?? null)
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <img src="data:image/svg+xml;base64,{{ base64_encode($qr) }}" alt="QR Code" class="mx-auto" style="width: 300px; height: 300px;">
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-semibold mb-4">Generate QR Code</h3>
        <form method="POST" action="{{ route('qr.generate') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text or URL" required>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Generate QR Code</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-semibold mb-4">Generate Encrypted QR Code</h3>
        <form method="POST" action="{{ route('qr.generate.encrypted') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter secret text" required>
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Password to encrypt" required>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Generate Encrypted QR</button>
        </form>
    </div>
</div>
@endsection

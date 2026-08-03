@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Text Encryption & Decryption</h1>

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="switchTab('aes')" id="tab-aes" class="tab-btn border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">AES-256</button>
            <button onclick="switchTab('base64')" id="tab-base64" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Base64</button>
            <button onclick="switchTab('caesar')" id="tab-caesar" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Caesar Cipher</button>
            <button onclick="switchTab('vigenere')" id="tab-vigenere" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Vigenere Cipher</button>
            <button onclick="switchTab('urlsafe')" id="tab-urlsafe" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">URL-Safe</button>
        </nav>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div id="panel-aes" class="tab-panel bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">AES-256-CBC Encryption</h3>
        <form method="POST" action="{{ route('text.aes.encrypt') }}" class="space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text to encrypt" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Encrypt</button>
        </form>
        <form method="POST" action="{{ route('text.aes.decrypt') }}" class="mt-4 space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter encrypted text to decrypt" required></textarea>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decrypt</button>
        </form>
    </div>

    <div id="panel-base64" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Base64 Encoding</h3>
        <form method="POST" action="{{ route('text.base64.encode') }}" class="space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text to encode" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Encode</button>
        </form>
        <form method="POST" action="{{ route('text.base64.decode') }}" class="mt-4 space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter Base64 to decode" required></textarea>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decode</button>
        </form>
    </div>

    <div id="panel-caesar" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Caesar Cipher</h3>
        <form method="POST" action="{{ route('text.caesar') }}" class="space-y-4">
            @csrf
            <input type="number" name="shift" min="1" max="25" value="3" class="border border-gray-300 rounded-md p-2 w-full" placeholder="Shift (1-25)" required>
            <select name="action" class="border border-gray-300 rounded-md p-2 w-full">
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Process</button>
        </form>
    </div>

    <div id="panel-vigenere" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Vigenere Cipher</h3>
        <form method="POST" action="{{ route('text.vigenere') }}" class="space-y-4">
            @csrf
            <input type="text" name="key" class="border border-gray-300 rounded-md p-2 w-full" placeholder="Keyword" required>
            <select name="action" class="border border-gray-300 rounded-md p-2 w-full">
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Process</button>
        </form>
    </div>

    <div id="panel-urlsafe" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">URL-Safe Base64</h3>
        <form method="POST" action="{{ route('text.urlsafe.encode') }}" class="space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text to encode" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Encode</button>
        </form>
        <form method="POST" action="{{ route('text.urlsafe.decode') }}" class="mt-4 space-y-4">
            @csrf
            <textarea name="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter URL-safe Base64 to decode" required></textarea>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decode</button>
        </form>
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-panel').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => { el.classList.remove('border-blue-500', 'text-blue-600'); el.classList.add('border-transparent', 'text-gray-500'); });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    const btn = document.getElementById('tab-' + tab);
    btn.classList.remove('border-transparent', 'text-gray-500');
    btn.classList.add('border-blue-500', 'text-blue-600');
}
@if(session('tab'))
switchTab('{{ session('tab') }}');
@endif
</script>
@endsection

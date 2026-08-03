@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Hash Generation & Verification</h1>

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="switchTab('hash')" id="tab-hash" class="tab-btn border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Hash Generator</button>
            <button onclick="switchTab('bcrypt')" id="tab-bcrypt" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">bcrypt</button>
            <button onclick="switchTab('argon2')" id="tab-argon2" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Argon2id</button>
            <button onclick="switchTab('hmac')" id="tab-hmac" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">HMAC</button>
            <button onclick="switchTab('verify')" id="tab-verify" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Verify Hash</button>
        </nav>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div id="panel-hash" class="tab-panel bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Hash Generator</h3>
        <form method="POST" action="{{ route('hash.generate') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required>
            <select name="algorithm" class="w-full border border-gray-300 rounded-md p-2">
                <option value="md5">MD5</option>
                <option value="sha1">SHA-1</option>
                <option value="sha256">SHA-256</option>
                <option value="sha512">SHA-512</option>
                <option value="crc32">CRC32</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate Hash</button>
        </form>
    </div>

    <div id="panel-bcrypt" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">bcrypt Hash</h3>
        <form method="POST" action="{{ route('hash.bcrypt') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate bcrypt</button>
        </form>
    </div>

    <div id="panel-argon2" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Argon2id Hash</h3>
        <form method="POST" action="{{ route('hash.argon2') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate Argon2id</button>
        </form>
    </div>

    <div id="panel-hmac" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">HMAC-SHA256</h3>
        <form method="POST" action="{{ route('hash.hmac') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter text" required>
            <input type="text" name="key" class="w-full border border-gray-300 rounded-md p-2" placeholder="Secret key" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate HMAC</button>
        </form>
    </div>

    <div id="panel-verify" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Verify Hash</h3>
        <form method="POST" action="{{ route('hash.verify') }}" class="space-y-4">
            @csrf
            <input type="text" name="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Original text" required>
            <input type="text" name="hash" class="w-full border border-gray-300 rounded-md p-2" placeholder="Hash to verify against" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Verify</button>
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

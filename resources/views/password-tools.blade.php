@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Password Tools</h1>

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="switchTab('generator')" id="tab-generator" class="tab-btn border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Generator</button>
            <button onclick="switchTab('strength')" id="tab-strength" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Strength Checker</button>
            <button onclick="switchTab('hash')" id="tab-hash" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Hash Password</button>
            <button onclick="switchTab('verify')" id="tab-verify" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Verify Password</button>
        </nav>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{!! session('success') !!}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div id="panel-generator" class="tab-panel bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Password Generator</h3>
        <form method="POST" action="{{ route('password.generate') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Length</label>
                    <input type="number" name="length" value="16" min="6" max="64" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                </div>
                <div class="flex items-center space-x-4 mt-6">
                    <label class="flex items-center"><input type="checkbox" name="uppercase" checked class="mr-2"> Uppercase</label>
                    <label class="flex items-center"><input type="checkbox" name="numbers" checked class="mr-2"> Numbers</label>
                    <label class="flex items-center"><input type="checkbox" name="symbols" checked class="mr-2"> Symbols</label>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate Password</button>
        </form>
    </div>

    <div id="panel-strength" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Password Strength Checker</h3>
        <form method="POST" action="{{ route('password.strength') }}" class="space-y-4">
            @csrf
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter password to check" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Check Strength</button>
        </form>
    </div>

    <div id="panel-hash" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Hash Password</h3>
        <form method="POST" action="{{ route('password.hash') }}" class="space-y-4">
            @csrf
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter password" required>
            <select name="algo" class="w-full border border-gray-300 rounded-md p-2">
                <option value="bcrypt">bcrypt</option>
                <option value="argon2">Argon2id</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Hash Password</button>
        </form>
    </div>

    <div id="panel-verify" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Verify Password</h3>
        <form method="POST" action="{{ route('password.verify') }}" class="space-y-4">
            @csrf
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter password" required>
            <input type="text" name="hash" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter hash" required>
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

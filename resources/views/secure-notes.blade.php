@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Secure Notes</h1>

    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="switchTab('create')" id="tab-create" class="tab-btn border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Create Note</button>
            <button onclick="switchTab('view')" id="tab-view" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">View Note</button>
        </nav>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div id="panel-create" class="tab-panel bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Create Secure Note</h3>
        <form method="POST" action="{{ route('secure-notes.store') }}" class="space-y-4">
            @csrf
            <input type="text" name="title" class="w-full border border-gray-300 rounded-md p-2" placeholder="Title (optional)">
            <textarea name="content" rows="6" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter your secret note" required></textarea>
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Set a password to protect this note" required>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Create Note</button>
        </form>
    </div>

    <div id="panel-view" class="tab-panel hidden bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">View Secure Note</h3>
        @if(session('token'))
        <form method="POST" action="{{ route('secure-notes.decrypt', session('token')) }}" class="space-y-4">
            @csrf
            <input type="text" class="w-full border border-gray-300 rounded-md p-2 bg-gray-50" value="{{ session('token') }}" readonly>
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter password" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decrypt Note</button>
        </form>
        @else
        <p class="text-gray-500">Create a note first to get a shareable link.</p>
        @endif
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

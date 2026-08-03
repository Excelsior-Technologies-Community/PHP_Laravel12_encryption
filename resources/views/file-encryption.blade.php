@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">File Encryption & Decryption</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Encrypt File</h3>
            <form method="POST" action="{{ route('file.encrypt') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="file" class="w-full border border-gray-300 rounded-md p-2" required>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Encrypt & Download</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Decrypt File</h3>
            <form method="POST" action="{{ route('file.decrypt') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="file" class="w-full border border-gray-300 rounded-md p-2" required>
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decrypt & Download</button>
            </form>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Bulk File Encryption (ZIP)</h3>
        <form method="POST" action="{{ route('file.bulk') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="files[]" multiple class="w-full border border-gray-300 rounded-md p-2" required>
            <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Encrypt Selected Files</button>
        </form>
    </div>
</div>
@endsection

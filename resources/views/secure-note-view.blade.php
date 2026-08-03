@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Decrypted Note</h1>
    <div class="bg-white p-6 rounded-lg shadow">
        <pre class="whitespace-pre-wrap text-gray-800">{{ $content }}</pre>
    </div>
    <p class="mt-4 text-sm text-red-600">This note is now destroyed and cannot be viewed again.</p>
</div>
@endsection

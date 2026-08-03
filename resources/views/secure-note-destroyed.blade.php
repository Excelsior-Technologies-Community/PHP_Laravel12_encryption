@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto text-center">
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Note Self-Destructed</h1>
    <p class="text-gray-600">This note has already been viewed and can only be viewed once.</p>
    <a href="{{ route('secure-notes') }}" class="mt-6 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Create New Note</a>
</div>
@endsection

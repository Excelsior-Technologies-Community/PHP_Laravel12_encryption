@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Enter Password</h1>
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-600 mb-4">This note is password protected. Enter the password to view it.</p>
        <form method="POST" action="{{ route('secure-notes.decrypt', $note->token) }}" class="space-y-4">
            @csrf
            <input type="text" name="password" class="w-full border border-gray-300 rounded-md p-2" placeholder="Enter password" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Decrypt Note</button>
        </form>
    </div>
</div>
@endsection

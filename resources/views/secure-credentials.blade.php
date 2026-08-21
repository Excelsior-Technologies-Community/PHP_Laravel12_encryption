@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Secure Credential Vault
            </h1>

            <p class="text-gray-600 mt-1">
                Store passwords, API keys and secrets using Laravel encryption.
            </p>
        </div>
    </div>


    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create Credential --}}
    <div class="bg-white p-6 rounded-lg shadow mb-8">

        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Add Secure Credential
        </h2>

        <form
            method="POST"
            action="{{ route('secure-credentials.store') }}"
            class="space-y-4"
        >

            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Service Name
                </label>

                <input
                    type="text"
                    name="service_name"
                    value="{{ old('service_name') }}"
                    placeholder="GitHub"
                    class="mt-1 w-full border border-gray-300 rounded-md p-2"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Username / Email
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="username@example.com"
                    class="mt-1 w-full border border-gray-300 rounded-md p-2"
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        class="mt-1 w-full border border-gray-300 rounded-md p-2"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        API Key
                    </label>

                    <input
                        type="password"
                        name="api_key"
                        placeholder="Enter API key"
                        class="mt-1 w-full border border-gray-300 rounded-md p-2"
                    >
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Secret
                </label>

                <input
                    type="password"
                    name="secret"
                    placeholder="Secret / token"
                    class="mt-1 w-full border border-gray-300 rounded-md p-2"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Notes
                </label>

                <textarea
                    name="notes"
                    rows="4"
                    placeholder="Additional sensitive information"
                    class="mt-1 w-full border border-gray-300 rounded-md p-2"
                >{{ old('notes') }}</textarea>
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
            >
                🔐 Save Encrypted Credential
            </button>

        </form>

    </div>


    {{-- Stored Credentials --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Stored Credentials
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Sensitive fields are stored in encrypted form.
            </p>
        </div>

        @if($credentials->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Service
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Username
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Stored
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>

                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">

                        @foreach($credentials as $credential)

                            <tr>

                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $credential->service_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    🔒 Encrypted
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $credential->created_at->format('d M Y, H:i') }}
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">

                                    <a
                                        href="{{ route('secure-credentials.show', $credential) }}"
                                        class="inline-block bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
                                    >
                                        Decrypt
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('secure-credentials.destroy', $credential) }}"
                                        class="inline"
                                        onsubmit="return confirm('Delete this credential?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-6 text-gray-500 text-center">
                No encrypted credentials stored yet.
            </div>

        @endif

    </div>

</div>

@endsection
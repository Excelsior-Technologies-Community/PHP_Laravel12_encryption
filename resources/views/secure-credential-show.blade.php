@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- BACK BUTTON --}}
    <div class="mb-6">
        <a
            href="{{ route('secure-credentials') }}"
            class="text-blue-600 hover:text-blue-800"
        >
            ← Back to Credential Vault
        </a>
    </div>


    {{-- CREDENTIAL CARD --}}
    <div class="bg-white rounded-lg shadow">

        {{-- HEADER --}}
        <div class="p-6 border-b border-gray-200">

            <h1 class="text-2xl font-bold text-gray-900">
                {{ $data['service_name'] }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Sensitive information has been decrypted for this view.
            </p>

        </div>


        {{-- ENCRYPTION VERSION --}}
        <div class="p-6 pb-0">

            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">

                <p class="text-sm text-blue-800">
                    Encryption Version:
                    <strong>v{{ $data['encryption_version'] }}</strong>
                </p>

            </div>

        </div>


        {{-- DECRYPTED DATA --}}
        <div class="p-6 space-y-5">

            {{-- USERNAME / EMAIL --}}
            <div>

                <label class="block text-sm font-medium text-gray-700">
                    Username / Email
                </label>

                <div class="mt-1 bg-gray-50 border rounded-md p-3 break-all">
                    {{ $data['username'] ?: 'Not provided' }}
                </div>

            </div>


            {{-- PASSWORD --}}
            <div>

                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <div class="mt-1 bg-gray-50 border rounded-md p-3 break-all font-mono">
                    {{ $data['password'] ?: 'Not provided' }}
                </div>

            </div>


            {{-- API KEY --}}
            <div>

                <label class="block text-sm font-medium text-gray-700">
                    API Key
                </label>

                <div class="mt-1 bg-gray-50 border rounded-md p-3 break-all font-mono">
                    {{ $data['api_key'] ?: 'Not provided' }}
                </div>

            </div>


            {{-- SECRET --}}
            <div>

                <label class="block text-sm font-medium text-gray-700">
                    Secret
                </label>

                <div class="mt-1 bg-gray-50 border rounded-md p-3 break-all font-mono">
                    {{ $data['secret'] ?: 'Not provided' }}
                </div>

            </div>


            {{-- NOTES --}}
            <div>

                <label class="block text-sm font-medium text-gray-700">
                    Notes
                </label>

                <div class="mt-1 bg-gray-50 border rounded-md p-3 whitespace-pre-wrap">
                    {{ $data['notes'] ?: 'Not provided' }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
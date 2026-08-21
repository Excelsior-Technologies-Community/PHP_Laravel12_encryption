<?php

namespace App\Http\Controllers;

use App\Models\SecureCredential;
use App\Services\EncryptionKeyService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class SecureCredentialController extends Controller
{
    public function __construct(
        private EncryptionKeyService $keyService
    ) {
    }

    /**
     * Display credential vault.
     */
    public function index()
    {
        $credentials = SecureCredential::latest()->get();

        return view(
            'secure-credentials',
            compact('credentials')
        );
    }

    /**
     * Store encrypted credential.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:5000',
            'api_key' => 'nullable|string|max:5000',
            'secret' => 'nullable|string|max:5000',
            'notes' => 'nullable|string|max:10000',
        ]);

        $credential = new SecureCredential();

        $credential->service_name = $request->service_name;

        $credential->username = $this->encryptNullable(
            $request->username
        );

        $credential->password = $this->encryptNullable(
            $request->password
        );

        $credential->api_key = $this->encryptNullable(
            $request->api_key
        );

        $credential->secret = $this->encryptNullable(
            $request->secret
        );

        $credential->notes = $this->encryptNullable(
            $request->notes
        );

        /*
         * Version 1 = current encryption key.
         * Version 2 = secondary/rotated key.
         */
        $credential->encryption_version = 1;

        $credential->save();

        return redirect()
            ->route('secure-credentials')
            ->with(
                'success',
                'Credential encrypted and stored successfully.'
            );
    }

    /**
     * Display decrypted credential.
     */
    public function show(SecureCredential $credential)
    {
        try {

            $data = [
                'id' => $credential->id,

                'service_name' =>
                    $credential->service_name,

                'username' =>
                    $this->decryptNullable(
                        $credential->username,
                        $credential->encryption_version
                    ),

                'password' =>
                    $this->decryptNullable(
                        $credential->password,
                        $credential->encryption_version
                    ),

                'api_key' =>
                    $this->decryptNullable(
                        $credential->api_key,
                        $credential->encryption_version
                    ),

                'secret' =>
                    $this->decryptNullable(
                        $credential->secret,
                        $credential->encryption_version
                    ),

                'notes' =>
                    $this->decryptNullable(
                        $credential->notes,
                        $credential->encryption_version
                    ),

                'encryption_version' =>
                    $credential->encryption_version,
            ];

            return view(
                'secure-credential-show',
                compact('data')
            );

        } catch (DecryptException $e) {

            return redirect()
                ->route('secure-credentials')
                ->with(
                    'error',
                    'Unable to decrypt this credential. Check the encryption key or encryption version.'
                );
        }
    }

    /**
     * Delete credential.
     */
    public function destroy(
        SecureCredential $credential
    ) {
        $credential->delete();

        return redirect()
            ->route('secure-credentials')
            ->with(
                'success',
                'Credential deleted successfully.'
            );
    }

    /**
     * Encrypt nullable value using the current active key.
     */
    private function encryptNullable(
        ?string $value
    ): ?string {

        if ($value === null || $value === '') {
            return null;
        }

        $key = $this->keyService->getCurrentKey();

        return $this->keyService
            ->encrypter($key)
            ->encryptString($value);
    }

    /**
     * Decrypt nullable value based on encryption version.
     */
    private function decryptNullable(
        ?string $value,
        int $version
    ): ?string {

        if ($value === null || $value === '') {
            return null;
        }

        $key = $version === 2
            ? $this->keyService->getSecondaryKey()
            : $this->keyService->getCurrentKey();

        if (!$key) {
            throw new DecryptException(
                'Encryption key is missing.'
            );
        }

        return $this->keyService
            ->encrypter($key)
            ->decryptString($value);
    }
}
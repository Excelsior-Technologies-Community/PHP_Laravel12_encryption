<?php

namespace App\Services;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;
use RuntimeException;

class EncryptionKeyService
{
    /**
     * Get the current Laravel APP_KEY.
     */
    public function getCurrentKey(): string
    {
        $key = config('app.key');

        if (!$key) {
            throw new RuntimeException(
                'APP_KEY is not configured.'
            );
        }

        return $this->normalizeKey($key);
    }

    /**
     * Get the secondary encryption key.
     */
    public function getSecondaryKey(): ?string
    {
        $key = config('app.encryption_key_v2');

        if (!$key) {
            return null;
        }

        return $this->normalizeKey($key);
    }

    /**
     * Get the current encryption version.
     */
    public function getCurrentVersion(): int
    {
        return 1;
    }

    /**
     * Create an AES-256 encryption key.
     */
    public function generateKey(): string
    {
        return 'base64:' . base64_encode(
            random_bytes(32)
        );
    }

    /**
     * Create an encrypter for a key.
     */
    public function encrypter(string $key): Encrypter
    {
        $key = $this->normalizeKey($key);

        return new Encrypter(
            $key,
            config('app.cipher', 'AES-256-CBC')
        );
    }

    /**
     * Encrypt a value using Laravel's normal serialized format.
     */
    public function encrypt(string $value, string $key): string
    {
        return $this->encrypter($key)->encrypt($value);
    }

    /**
     * Decrypt a value encrypted using Laravel's encrypt() method.
     */
    public function decrypt(string $payload, string $key): string
    {
        return $this->encrypter($key)->decrypt($payload);
    }

    /**
     * Decrypt a value safely.
     *
     * Supports:
     * - Laravel encrypt()
     * - Laravel encryptString()
     */
    public function decryptFlexible(
        string $payload,
        string $key
    ): string {
        $encrypter = $this->encrypter($key);

        /*
         * First try Laravel's normal decrypt().
         *
         * This handles values created with:
         *
         * $encrypter->encrypt($value)
         */
        try {
            return $encrypter->decrypt($payload);
        } catch (\Throwable $e) {
            /*
             * If normal decrypt fails because the original value
             * was encrypted using encryptString(), decryptString()
             * returns the raw string without unserializing it.
             */
        }

        try {
            return $encrypter->decryptString($payload);
        } catch (\Throwable $e) {
            throw new RuntimeException(
                'Unable to decrypt encrypted value.'
            );
        }
    }

    /**
     * Normalize base64 Laravel keys.
     */
    private function normalizeKey(string $key): string
    {
        if (Str::startsWith($key, 'base64:')) {
            $decoded = base64_decode(
                substr($key, 7),
                true
            );

            if ($decoded === false) {
                throw new RuntimeException(
                    'Invalid base64 encryption key.'
                );
            }

            $key = $decoded;
        }

        if (strlen($key) !== 32) {
            throw new RuntimeException(
                'Encryption key must be a valid 32-byte AES-256 key.'
            );
        }

        return $key;
    }
}
<?php

namespace App\Console\Commands;

use App\Models\SecureCredential;
use App\Services\EncryptionKeyService;
use Illuminate\Console\Command;
use Throwable;

class RotateEncryptionKey extends Command
{
    protected $signature = 'encryption:rotate
                            {--generate : Generate a new encryption key automatically}';

    protected $description =
        'Rotate secure credential encryption from APP_KEY to ENCRYPTION_KEY_V2';

    public function handle(
        EncryptionKeyService $keyService
    ): int {

        $this->info(
            'Starting encryption key rotation...'
        );

        $this->newLine();

        /*
         * ---------------------------------------------------------
         * GENERATE NEW KEY
         * ---------------------------------------------------------
         */
        if ($this->option('generate')) {

            $newKey = $keyService->generateKey();

            $this->warn(
                'Generated ENCRYPTION_KEY_V2:'
            );

            $this->line($newKey);

            $this->newLine();

            $this->warn(
                'Copy this key into your .env file:'
            );

            $this->line(
                'ENCRYPTION_KEY_V2=' . $newKey
            );

            $this->newLine();

            $this->comment(
                'After adding the key to .env, run:'
            );

            $this->line(
                'php artisan optimize:clear'
            );

            $this->line(
                'php artisan encryption:rotate'
            );

            return self::SUCCESS;
        }

        /*
         * ---------------------------------------------------------
         * GET OLD KEY
         * ---------------------------------------------------------
         */
        $currentKey = $keyService->getCurrentKey();

        /*
         * ---------------------------------------------------------
         * GET NEW KEY
         * ---------------------------------------------------------
         */
        $newKey = $keyService->getSecondaryKey();

        if (!$newKey) {

            $this->error(
                'ENCRYPTION_KEY_V2 is not configured.'
            );

            $this->line(
                'Run: php artisan encryption:rotate --generate'
            );

            return self::FAILURE;
        }

        /*
         * ---------------------------------------------------------
         * CREATE ENCRYPTERS
         * ---------------------------------------------------------
         */
        $newEncrypter = $keyService->encrypter(
            $newKey
        );

        /*
         * ---------------------------------------------------------
         * GET V1 CREDENTIALS
         * ---------------------------------------------------------
         */
        $credentials = SecureCredential::where(
            'encryption_version',
            1
        )->get();

        if ($credentials->isEmpty()) {

            $this->info(
                'No version 1 credentials require rotation.'
            );

            return self::SUCCESS;
        }

        /*
         * ---------------------------------------------------------
         * ENCRYPTED FIELDS
         * ---------------------------------------------------------
         */
        $fields = [
            'username',
            'password',
            'api_key',
            'secret',
            'notes',
        ];

        $successCount = 0;
        $failureCount = 0;

        /*
         * ---------------------------------------------------------
         * ROTATE EACH CREDENTIAL
         * ---------------------------------------------------------
         */
        foreach ($credentials as $credential) {

            try {

                foreach ($fields as $field) {

                    $encryptedValue =
                        $credential->{$field};

                    /*
                     * Nothing to rotate.
                     */
                    if (
                        $encryptedValue === null ||
                        $encryptedValue === ''
                    ) {
                        continue;
                    }

                    /*
                     * Decrypt using the OLD APP_KEY.
                     *
                     * decryptFlexible() supports both:
                     *
                     * - encrypt()
                     * - encryptString()
                     */
                    $plainText =
                        $keyService->decryptFlexible(
                            $encryptedValue,
                            $currentKey
                        );

                    /*
                     * Encrypt using the NEW key.
                     */
                    $credential->{$field} =
                        $newEncrypter->encrypt(
                            $plainText
                        );
                }

                /*
                 * Mark credential as version 2.
                 */
                $credential->encryption_version = 2;

                $credential->save();

                $successCount++;

                $this->info(
                    "✓ Credential #{$credential->id} rotated successfully."
                );

            } catch (Throwable $e) {

                $failureCount++;

                $this->error(
                    "✗ Credential #{$credential->id} failed: {$e->getMessage()}"
                );
            }
        }

        /*
         * ---------------------------------------------------------
         * SUMMARY
         * ---------------------------------------------------------
         */
        $this->newLine();

        $this->info(
            'Rotation complete.'
        );

        $this->line(
            "Successfully rotated: {$successCount}"
        );

        $this->line(
            "Failed: {$failureCount}"
        );

        return $failureCount > 0
            ? self::FAILURE
            : self::SUCCESS;
    }
}
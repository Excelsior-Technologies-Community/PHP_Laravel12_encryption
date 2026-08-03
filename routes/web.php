<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextEncryptionController;
use App\Http\Controllers\FileEncryptionController;
use App\Http\Controllers\HashController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SecureNoteController;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('home');
});

Route::get('/text-encryption', [TextEncryptionController::class, 'index'])->name('text-encryption');
Route::post('/text/aes/encrypt', [TextEncryptionController::class, 'aesEncrypt'])->name('text.aes.encrypt');
Route::post('/text/aes/decrypt', [TextEncryptionController::class, 'aesDecrypt'])->name('text.aes.decrypt');
Route::post('/text/base64/encode', [TextEncryptionController::class, 'base64Encode'])->name('text.base64.encode');
Route::post('/text/base64/decode', [TextEncryptionController::class, 'base64Decode'])->name('text.base64.decode');
Route::post('/text/caesar', [TextEncryptionController::class, 'caesarCipher'])->name('text.caesar');
Route::post('/text/vigenere', [TextEncryptionController::class, 'vigenereCipher'])->name('text.vigenere');
Route::post('/text/urlsafe/encode', [TextEncryptionController::class, 'urlSafe'])->name('text.urlsafe.encode');
Route::post('/text/urlsafe/decode', [TextEncryptionController::class, 'urlSafe'])->name('text.urlsafe.decode');

Route::get('/file-encryption', [FileEncryptionController::class, 'index'])->name('file-encryption');
Route::post('/file/encrypt', [FileEncryptionController::class, 'encrypt'])->name('file.encrypt');
Route::post('/file/decrypt', [FileEncryptionController::class, 'decrypt'])->name('file.decrypt');
Route::post('/file/bulk', [FileEncryptionController::class, 'bulkEncrypt'])->name('file.bulk');

Route::get('/hash-tools', [HashController::class, 'index'])->name('hash-tools');
Route::post('/hash/generate', [HashController::class, 'generate'])->name('hash.generate');
Route::post('/hash/bcrypt', [HashController::class, 'bcrypt'])->name('hash.bcrypt');
Route::post('/hash/argon2', [HashController::class, 'argon2'])->name('hash.argon2');
Route::post('/hash/hmac', [HashController::class, 'hmac'])->name('hash.hmac');
Route::post('/hash/verify', [HashController::class, 'verify'])->name('hash.verify');

Route::get('/password-tools', [PasswordController::class, 'index'])->name('password-tools');
Route::post('/password/generate', [PasswordController::class, 'generate'])->name('password.generate');
Route::post('/password/strength', [PasswordController::class, 'checkStrength'])->name('password.strength');
Route::post('/password/hash', [PasswordController::class, 'hashPassword'])->name('password.hash');
Route::post('/password/verify', [PasswordController::class, 'verifyPassword'])->name('password.verify');

Route::get('/secure-notes', [SecureNoteController::class, 'index'])->name('secure-notes');
Route::post('/secure-notes', [SecureNoteController::class, 'store'])->name('secure-notes.store');
Route::get('/secure-notes/{token}', [SecureNoteController::class, 'view'])->name('secure-notes.view');
Route::post('/secure-notes/{token}', [SecureNoteController::class, 'decrypt'])->name('secure-notes.decrypt');

Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qr-code');
Route::post('/qr/generate', [QrCodeController::class, 'generate'])->name('qr.generate');
Route::post('/qr/generate/encrypted', [QrCodeController::class, 'generateEncrypted'])->name('qr.generate.encrypted');


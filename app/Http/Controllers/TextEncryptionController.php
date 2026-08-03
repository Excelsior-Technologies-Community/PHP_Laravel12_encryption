<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TextEncryptionController extends Controller
{
    public function index()
    {
        return view('text-encryption');
    }

    public function aesEncrypt(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        try {
            $encrypted = Crypt::encryptString($request->text);
            return back()->with('success', 'Encrypted: ' . $encrypted)->with('tab', 'aes');
        } catch (\Exception $e) {
            return back()->with('error', 'Encryption failed: ' . $e->getMessage())->with('tab', 'aes');
        }
    }

    public function aesDecrypt(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        try {
            $decrypted = Crypt::decryptString($request->text);
            return back()->with('success', 'Decrypted: ' . $decrypted)->with('tab', 'aes');
        } catch (DecryptException $e) {
            return back()->with('error', 'Decryption failed: Invalid encrypted text.')->with('tab', 'aes');
        }
    }

    public function base64Encode(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $encoded = base64_encode($request->text);
        return back()->with('success', 'Base64 Encoded: ' . $encoded)->with('tab', 'base64');
    }

    public function base64Decode(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $decoded = @base64_decode($request->text, true);
        if ($decoded === false) {
            return back()->with('error', 'Invalid Base64 string.')->with('tab', 'base64');
        }
        return back()->with('success', 'Base64 Decoded: ' . $decoded)->with('tab', 'base64');
    }

    public function caesarCipher(Request $request)
    {
        $request->validate(['text' => 'required|string', 'shift' => 'required|integer|min:1|max:25', 'action' => 'required|in:encrypt,decrypt']);
        $shift = $request->shift;
        if ($request->action === 'decrypt') {
            $shift = 26 - $shift;
        }
        $result = str_rot13($request->text); // fallback for demo
        // Custom Caesar cipher
        $result = '';
        foreach (str_split($request->text) as $char) {
            if (ctype_alpha($char)) {
                $base = ctype_upper($char) ? ord('A') : ord('a');
                $result .= chr(($base + (ord($char) - $base + $shift) % 26));
            } else {
                $result .= $char;
            }
        }
        $action = $request->action === 'encrypt' ? 'Encrypted' : 'Decrypted';
        return back()->with('success', "Caesar {$action}: " . $result)->with('tab', 'caesar');
    }

    public function vigenereCipher(Request $request)
    {
        $request->validate(['text' => 'required|string', 'key' => 'required|string|min:1|max:100', 'action' => 'required|in:encrypt,decrypt']);
        $key = strtoupper($request->key);
        $text = strtoupper($request->text);
        $result = '';
        $keyIndex = 0;
        $keyLen = strlen($key);

        foreach (str_split($text) as $char) {
            if (ctype_alpha($char)) {
                $shift = ord($key[$keyIndex % $keyLen]) - ord('A');
                if ($request->action === 'decrypt') {
                    $shift = 26 - $shift;
                }
                $base = ord('A');
                $result .= chr($base + (ord($char) - $base + $shift) % 26);
                $keyIndex++;
            } else {
                $result .= $char;
            }
        }
        $action = $request->action === 'encrypt' ? 'Encrypted' : 'Decrypted';
        return back()->with('success', "Vigenere {$action}: " . $result)->with('tab', 'vigenere');
    }

    public function urlSafe(Request $request)
    {
        $request->validate(['text' => 'required|string', 'action' => 'required|in:encode,decode']);
        if ($request->action === 'encode') {
            $result = rtrim(strtr(base64_encode($request->text), '+/', '-_'), '=');
        } else {
            $result = base64_decode(strtr($request->text, '-_', '+/'));
            if ($result === false && $request->text !== '') {
                return back()->with('error', 'Invalid URL-safe Base64 string.')->with('tab', 'urlsafe');
            }
        }
        $action = $request->action === 'encode' ? 'URL-safe Encoded' : 'URL-safe Decoded';
        return back()->with('success', "{$action}: " . $result)->with('tab', 'urlsafe');
    }
}

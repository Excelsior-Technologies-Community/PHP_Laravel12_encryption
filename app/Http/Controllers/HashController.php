<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HashController extends Controller
{
    public function index()
    {
        return view('hash-tools');
    }

    public function generate(Request $request)
    {
        $request->validate(['text' => 'required|string', 'algorithm' => 'required|string']);
        $text = $request->text;
        $algo = $request->algorithm;
        $hash = match ($algo) {
            'md5' => md5($text),
            'sha1' => sha1($text),
            'sha256' => hash('sha256', $text),
            'sha512' => hash('sha512', $text),
            'crc32' => hash('crc32', $text),
            default => null,
        };
        if ($hash === null) {
            return back()->with('error', 'Invalid algorithm selected.')->with('tab', 'hash');
        }
        return back()->with('success', "{$algo} Hash: " . $hash)->with('tab', 'hash');
    }

    public function bcrypt(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $hash = bcrypt($request->text);
        return back()->with('success', 'bcrypt Hash: ' . $hash)->with('tab', 'bcrypt');
    }

    public function argon2(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $hash = password_hash($request->text, PASSWORD_ARGON2ID);
        return back()->with('success', 'Argon2id Hash: ' . $hash)->with('tab', 'argon2');
    }

    public function hmac(Request $request)
    {
        $request->validate(['text' => 'required|string', 'key' => 'required|string']);
        $hash = hash_hmac('sha256', $request->text, $request->key);
        return back()->with('success', 'HMAC-SHA256: ' . $hash)->with('tab', 'hmac');
    }

    public function verify(Request $request)
    {
        $request->validate(['text' => 'required|string', 'hash' => 'required|string']);
        $algo = $this->detectAlgorithm($request->hash);
        $valid = false;
        if ($algo === 'bcrypt' || $algo === 'argon2') {
            $valid = password_verify($request->text, $request->hash);
        } elseif (in_array($algo, ['md5', 'sha1', 'sha256', 'sha512'])) {
            $valid = hash_equals($request->hash, hash($algo, $request->text));
        } else {
            $valid = hash_equals($request->hash, $request->text);
        }
        if ($valid) {
            return back()->with('success', 'Hash verified successfully!')->with('tab', 'verify');
        }
        return back()->with('error', 'Hash verification failed.')->with('tab', 'verify');
    }

    private function detectAlgorithm(string $hash): string
    {
        $len = strlen($hash);
        if (preg_match('/^\$2[aby]?\$/', $hash)) return 'bcrypt';
        if (preg_match('/^\$argon2/i', $hash)) return 'argon2';
        if ($len === 32) return 'md5';
        if ($len === 40) return 'sha1';
        if ($len === 64) return 'sha256';
        if ($len === 128) return 'sha512';
        return 'unknown';
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index()
    {
        return view('password-tools');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'length' => 'required|integer|min:6|max:64',
            'symbols' => 'sometimes|boolean',
            'numbers' => 'sometimes|boolean',
            'uppercase' => 'sometimes|boolean',
        ]);
        $length = $request->length;
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if ($request->uppercase) $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($request->numbers) $chars .= '0123456789';
        if ($request->symbols) $chars .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        $password = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }
        return back()->with('success', 'Generated Password: ' . $password)->with('tab', 'generator');
    }

    public function checkStrength(Request $request)
    {
        $request->validate(['password' => 'required|string']);
        $password = $request->password;
        $score = 0;
        if (strlen($password) >= 8) $score++;
        if (strlen($password) >= 12) $score++;
        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $score++;

        $levels = ['Very Weak', 'Weak', 'Fair', 'Strong', 'Very Strong'];
        $level = $levels[min($score, 4)];
        $colors = ['red', 'orange', 'yellow', 'blue', 'green'];
        $color = $colors[min($score, 4)];

        return back()->with('success', "Strength: <span class='text-{$color}-600 font-bold'>{$level}</span> (Score: {$score}/6)")->with('tab', 'strength');
    }

    public function hashPassword(Request $request)
    {
        $request->validate(['password' => 'required|string', 'algo' => 'required|in:bcrypt,argon2']);
        $algo = $request->algo;
        $hash = $algo === 'bcrypt' ? bcrypt($request->password) : password_hash($request->password, PASSWORD_ARGON2ID);
        return back()->with('success', ucfirst($algo) . " Hash: " . $hash)->with('tab', 'hash');
    }

    public function verifyPassword(Request $request)
    {
        $request->validate(['password' => 'required|string', 'hash' => 'required|string']);
        $valid = password_verify($request->password, $request->hash);
        if ($valid) {
            return back()->with('success', 'Password verified successfully!')->with('tab', 'verify');
        }
        return back()->with('error', 'Password verification failed.')->with('tab', 'verify');
    }
}

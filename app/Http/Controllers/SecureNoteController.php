<?php

namespace App\Http\Controllers;

use App\Models\SecureNote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class SecureNoteController extends Controller
{
    public function index()
    {
        return view('secure-notes');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'password' => 'required|string|min:4',
        ]);
        $note = new SecureNote();
        $note->title = $request->title;
        $note->content = Crypt::encryptString($request->content);
        $note->password_hash = password_hash($request->password, PASSWORD_BCRYPT);
        $note->token = Str::random(32);
        $note->is_viewed = false;
        $note->save();

        $url = route('secure-notes.view', $note->token);
        return back()->with('success', 'Note created! Shareable link: ' . $url)->with('tab', 'create')->with('token', $note->token);
    }

    public function view($token)
    {
        $note = SecureNote::where('token', $token)->firstOrFail();
        if ($note->is_viewed) {
            return view('secure-note-destroyed');
        }
        return view('secure-note-password', compact('note'));
    }

    public function decrypt(Request $request, $token)
    {
        $request->validate(['password' => 'required|string']);
        $note = SecureNote::where('token', $token)->firstOrFail();
        if ($note->is_viewed) {
            return redirect()->route('secure-notes.view', $token);
        }
        if (!password_verify($request->password, $note->password_hash)) {
            return back()->with('error', 'Invalid password.')->with('token', $token);
        }
        $note->is_viewed = true;
        $note->viewed_at = now();
        $note->save();
        $content = Crypt::decryptString($note->content);
        return view('secure-note-view', compact('content'));
    }
}

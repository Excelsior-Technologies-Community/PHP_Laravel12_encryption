<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileEncryptionController extends Controller
{
    public function index()
    {
        return view('file-encryption');
    }

    public function encrypt(Request $request)
    {
        $request->validate(['file' => 'required|file|max:10240']);
        $file = $request->file('file');
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        $encrypted = Crypt::encryptString($content);
        $encryptedPath = 'encrypted/' . uniqid() . '_' . $file->getClientOriginalName() . '.enc';
        Storage::put($encryptedPath, $encrypted);
        return Storage::download($encryptedPath);
    }

    public function decrypt(Request $request)
    {
        $request->validate(['file' => 'required|file|max:10240']);
        $file = $request->file('file');
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        try {
            $decrypted = Crypt::decryptString($content);
            $decryptedPath = 'decrypted/' . uniqid() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            Storage::put($decryptedPath, $decrypted);
            return Storage::download($decryptedPath);
        } catch (DecryptException $e) {
            return back()->with('error', 'Decryption failed: Invalid encrypted file.');
        }
    }

    public function bulkEncrypt(Request $request)
    {
        $request->validate(['files' => 'required|array|min:1', 'files.*' => 'file|max:10240']);
        $files = $request->file('files');
        $zipName = 'encrypted_' . uniqid() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipName);
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $file) {
                $content = file_get_contents($file->getRealPath());
                $encrypted = Crypt::encryptString($content);
                $zip->addFromString($file->getClientOriginalName() . '.enc', $encrypted);
            }
            $zip->close();
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }
        return back()->with('error', 'Failed to create zip archive.');
    }
}

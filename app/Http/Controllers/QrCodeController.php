<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('qr-code');
    }

    public function generate(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $qr = QrCode::format('svg')->size(300)->generate($request->text);
        return view('qr-code', compact('qr'));
    }

    public function generateEncrypted(Request $request)
    {
        $request->validate(['text' => 'required|string', 'password' => 'required|string']);
        $encrypted = Crypt::encryptString($request->text);
        $qr = QrCode::format('svg')->size(300)->generate($encrypted);
        return view('qr-code', compact('qr'));
    }
}

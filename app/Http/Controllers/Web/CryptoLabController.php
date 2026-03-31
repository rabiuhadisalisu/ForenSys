<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CryptoLabController extends Controller
{
    public function index(): View
    {
        return view('pages.tools.crypto-lab', [
            'activeNav' => 'crypto-lab',
            'pageTitle' => 'Cryptography Learning Lab',
            'pageDescription' => 'Educational encryption, signing, hashing, and encoding exercises for user-owned input only.',
        ]);
    }
}

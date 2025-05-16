<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function success(Request $request)
{
    // Hapus session keranjang user
    session()->forget('keranjang');

    // Redirect ke dashboard
    return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil!');
}

}

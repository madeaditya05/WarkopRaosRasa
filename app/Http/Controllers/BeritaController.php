<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    public function index()
    {
        // Pastikan API key valid di .env
        $apiKey = env('NEWSAPI_KEY');
        
        // Ubah kata kunci pencarian menjadi lebih relevan dengan warung mie dan kopi
        $url = "https://newsapi.org/v2/everything?q=warung%20mie%20kopi&language=id&sortBy=publishedAt&pageSize=6&apiKey={$apiKey}";

        // Mengambil data dari API NewsAPI
        $response = Http::get($url);

        // Menangani jika respons API gagal
        if (!$response->successful()) {
            dd($response->body()); // Debugging untuk memeriksa error
        }

        // Mengambil data berita dari API
        $berita = [];
        $data = $response->json();
        $berita = $data['articles'] ?? [];

        // Mengembalikan hasil ke view 'berita'
        return view('berita', compact('berita'));
    }
}

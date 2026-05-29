<?php

namespace App\Http\Controllers;

class TermsController extends Controller
{
    public function index()
    {
        $settingsPath = storage_path('app/settings.json');
        $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [];
        
        $content = $settings['terms_content'] ?? 'Konten Syarat & Ketentuan belum diatur oleh admin.';
        
        return view('legal.terms', compact('content'));
    }
}
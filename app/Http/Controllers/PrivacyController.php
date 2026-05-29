<?php

namespace App\Http\Controllers;

class PrivacyController extends Controller
{
    public function index()
    {
        $settingsPath = storage_path('app/settings.json');
        $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [];
        
        $content = $settings['privacy_content'] ?? 'Konten Kebijakan Privasi belum diatur oleh admin.';
        
        return view('legal.privacy', compact('content'));
    }
}
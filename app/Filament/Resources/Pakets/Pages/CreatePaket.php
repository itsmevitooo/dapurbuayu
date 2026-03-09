<?php

namespace App\Filament\Resources\Pakets\Pages;

use App\Filament\Resources\Pakets\PaketResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaket extends CreateRecord
{
    protected static string $resource = PaketResource::class;

    // Fungsi untuk mengarahkan halaman setelah simpan (Create)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
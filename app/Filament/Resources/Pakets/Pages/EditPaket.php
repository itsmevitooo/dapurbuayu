<?php

namespace App\Filament\Resources\Pakets\Pages;

use App\Filament\Resources\Pakets\PaketResource;
use Filament\Resources\Pages\EditRecord;

class EditPaket extends EditRecord
{
    protected static string $resource = PaketResource::class;

    // Fungsi untuk mengarahkan halaman setelah simpan (Update)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
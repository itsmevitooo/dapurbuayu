<?php

namespace App\Filament\Resources\Pakets\Pages;

use App\Filament\Resources\Pakets\PaketResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaket extends CreateRecord
{
    protected static string $resource = PaketResource::class;

    // Tambahkan aksi ini agar form tetap mempertahankan state/isian 
    // data sebelumnya setelah tombol "Create another" diklik.
    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Buat & Tambah Lainnya (Make Another)');
    }

    // Fungsi untuk mengarahkan halaman setelah simpan (Create)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}